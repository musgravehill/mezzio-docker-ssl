<?php

declare(strict_types=1);

namespace News\Handler;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use News\Contract\NewsServiceInterface;
use News\ValueObject\IdUUIDv7;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteHandler implements RequestHandlerInterface
{

    public function __construct(
        private readonly NewsServiceInterface $newsService,
        private readonly InputFilterInterface $inputFilter,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // $id = $request->getAttribute('id'); // https://x.not-real.ru/news/018b19a4-20eb-70f5-810a-ac7b724ad85d
        $inputs = $request->getAttributes();
        $this->inputFilter->setData($inputs);
        if (!$this->inputFilter->isValid()) {
            $messages = $this->inputFilter->getMessages();
            //throw new InvalidArgumentException(message: json_encode($messages));
            return new JsonResponse($messages, StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $id = IdUUIDv7::fromString($this->inputFilter->getValue('id'));
        $this->newsService->delete($id);

        return new JsonResponse([], StatusCodeInterface::STATUS_OK);
    }
}
