<?php

declare(strict_types=1);

namespace Oauth2\Middleware;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ProtectedResourceMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResourceServer $resourceServer,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $request = $this->resourceServer->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $exception) {
            $response = $this->responseFactory->createResponse();
            return $exception->generateHttpResponse($response);
        } catch (Throwable $exception) {
            $response = $this->responseFactory->createResponse();
            return (new OAuthServerException($exception->getMessage(), 0, 'OAuthServerException: unsupported exception', 500))
                ->generateHttpResponse($response);
        }

        return $handler->handle($request);
    }
}
