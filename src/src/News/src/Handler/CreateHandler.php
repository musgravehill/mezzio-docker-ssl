<?php

declare(strict_types=1);

namespace News\Handler;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use News\Contract\NewsServiceInterface;
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

        return new JsonResponse([], StatusCodeInterface::STATUS_CREATED);
        // $news = $this->newsService->create($data['title'], $data['text']);        
        // return new JsonResponse([], StatusCodeInterface::STATUS_CREATED);
    }
}
