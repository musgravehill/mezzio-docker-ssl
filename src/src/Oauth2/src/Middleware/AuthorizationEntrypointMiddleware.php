<?php

declare(strict_types=1);

namespace Oauth2\Middleware;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware as LeagueAuthorizationServerMiddleware;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Oauth2\Entity\UserEntity;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class AuthorizationEntrypointMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly AuthorizationServer $authorizationServer,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        /*
        // Validate the HTTP request and return an AuthorizationRequest object.
        $authRequest = $server->validateAuthorizationRequest($request);

        // The auth request object can be serialized and saved into a user's session.
        // You will probably want to redirect the user at this point to a login endpoint.

        // Once the user has logged in set the user on the AuthorizationRequest
        $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface

        // At this point you should redirect the user to an authorization page.
        // This form will ask the user to approve the client and the scopes requested.

        // Once the user has approved or denied the client update the status
        // (true = approved, false = denied)
        $authRequest->setAuthorizationApproved(true);

        // Return the HTTP redirect response
        return $server->completeAuthorizationRequest($authRequest, $response);

        */
        try {
            $authRequest = $this->authorizationServer->validateAuthorizationRequest($request);

            // todo start
            // The next handler must take care of providing the
            // authenticate user, setUser and the approval
            $authRequest->setUser(new UserEntity('ebe474a0-45b9-40ef-ad96-dde9bca5e19e')); // an instance of UserEntityInterface
            $authRequest->setAuthorizationApproved(true);
            // todo end

            // add payload '$authRequest' for next usage
            $request = $request->withAttribute(AuthorizationRequest::class, $authRequest);

            return $handler->handle($request);
        } catch (OAuthServerException $exception) {
            $response = $this->responseFactory->createResponse();
            return $exception->generateHttpResponse($response);
        } catch (Throwable $exception) {
            $response = $this->responseFactory->createResponse();
            return (new OAuthServerException($exception->getMessage(), 0, 'OAuthServerException: unsupported exception', 500))
                ->generateHttpResponse($response);
        }
    }
}
