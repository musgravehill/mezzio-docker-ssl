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

class ListHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly NewsServiceInterface $newsService,
        private readonly InputFilterInterface $inputFilter
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $this->inputFilter->setData($queryParams);
        if (!$this->inputFilter->isValid()) {
            $messages = $this->inputFilter->getMessages();
            //throw new InvalidArgumentException(message: json_encode($messages));
            return new JsonResponse($messages, StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        //TODO valueObject 
        $page = 1;
        $limit = 1;

        $news = $this->newsService->findAll($page, $limit);

        $data = [];
        foreach ($news as $item) {
            $data[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'text' => $item->getText(),
                'created' => $item->getCreated()->format('c')
            ];
        }
        return new JsonResponse($data, StatusCodeInterface::STATUS_OK);
    }
}
