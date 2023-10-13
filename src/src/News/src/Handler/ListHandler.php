<?php

declare(strict_types=1);

namespace News\Handler;

use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Laminas\Diactoros\Response\JsonResponse;
use News\Contract\NewsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Laminas\InputFilter\InputFilterInterface;
use Mezzio\ProblemDetails\ProblemDetailsResponseFactory;
use News\Dto\NewsListItemDto;
use News\ValueObject\CountOnPage;
use News\ValueObject\PageNumber;

class ListHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly NewsServiceInterface $newsService,
        private readonly InputFilterInterface $inputFilter,
        private ProblemDetailsResponseFactory $problemDetailsFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $inputs = $request->getQueryParams();
        $this->inputFilter->setData($inputs);
        if (!$this->inputFilter->isValid()) {
            $messages = $this->inputFilter->getMessages();
            //throw new InvalidArgumentException(message: json_encode($messages));
            //return new JsonResponse($messages, StatusCodeInterface::STATUS_BAD_REQUEST);
            
            return $this->problemDetailsFactory->createResponse(
                request: $request,
                status: StatusCodeInterface::STATUS_OK,
                detail: 'Domain transaction request failed validation',
                title: '',
                type: '',
                additional: ['messages' => $messages],
            );           
        }

        $page = new PageNumber($this->inputFilter->getValue('page'));
        $limit = new CountOnPage($this->inputFilter->getValue('limit'));

        /**
         * @var NewsListItemDto[] $news
         */
        $news = $this->newsService->findAll($page, $limit);

        $data = [];
        foreach ($news as $item) {
            $data[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'text' => $item->getText(),
                'created' => $item->getCreatedAt()
            ];
        }
        return new JsonResponse($data, StatusCodeInterface::STATUS_OK);
    }
}
