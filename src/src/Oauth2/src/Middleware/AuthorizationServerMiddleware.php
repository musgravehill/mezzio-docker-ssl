<?php

declare(strict_types=1);

namespace Oauth2\Middleware;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware as LeagueAuthorizationServerMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class AuthorizationServerMiddleware implements MiddlewareInterface
{
    public function  __construct(
        private readonly AuthorizationServer $authorizationServer,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // new LeagueAuthorizationServerMiddleware($this->authorizationServer);
        /*try {
            $response = $this->authorizationServer->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse($response);
            // @codeCoverageIgnoreEnd
        }
        // Pass the request and response on to the next responder in the chain
        return $next($request, $response);
        */
        try {
            $authRequest = $this->authorizationServer->validateAuthorizationRequest($request);

            // The next handler must take care of providing the
            // authenticated user and the approval
            $authRequest->setAuthorizationApproved(false);

            return $handler->handle($request->withAttribute(AuthorizationRequest::class, $authRequest));
        } catch (OAuthServerException $exception) {
            $response = $this->responseFactory->createResponse();
            // The validation throws this exception if the request is not valid
            // for example when the client id is invalid
            return $exception->generateHttpResponse($response);
        } catch (Throwable $exception) {
            $response = $this->responseFactory->createResponse();
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse($response);
        }
    }
}
