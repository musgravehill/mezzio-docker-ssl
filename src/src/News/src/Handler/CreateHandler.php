<?php

declare(strict_types=1);

namespace News\Handler;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use News\Contract\NewsServiceInterface;
use News\ValueObject\NewsText;
use News\ValueObject\NewsTitle;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class CreateHandler implements RequestHandlerInterface
{

    public function __construct(
        private readonly NewsServiceInterface $newsService,
        private readonly InputFilterInterface $inputFilter,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $inputs = $request->getParsedBody();
        $this->inputFilter->setData($inputs);
        if (!$this->inputFilter->isValid()) {
            $messages = $this->inputFilter->getMessages();
            //throw new InvalidArgumentException(message: json_encode($messages));
            return new JsonResponse($messages, StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        // valueObject::prepare() - controversial decision. 
        // Does not give the client information about the mistakes he has made.
        $newsTitle = new NewsTitle(NewsTitle::prepare($this->inputFilter->getValue('title')));
        $newsText = new NewsText(NewsText::prepare($this->inputFilter->getValue('text')));

        $item = $this->newsService->create($newsTitle, $newsText);

        $data = [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'text' => $item->getText(),
            'created' => $item->getCreatedAt(),
            'status' => $item->getStatus(),
        ];

        return new JsonResponse($data, StatusCodeInterface::STATUS_OK);
    }
}
