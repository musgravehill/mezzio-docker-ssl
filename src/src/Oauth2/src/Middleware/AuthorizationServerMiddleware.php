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




    /*
    FOR ENDPOINt MIDDLEWARE 
    $app->post('/access_token', function (ServerRequestInterface $request, ResponseInterface $response) use ($server) {

    try {
    
        // Try to respond to the request
        return $server->respondToAccessTokenRequest($request, $response);

    } catch (\League\OAuth2\Server\Exception\OAuthServerException $exception) {
    
        // All instances of OAuthServerException can be formatted into a HTTP response
        return $exception->generateHttpResponse($response);
        
    } catch (\Exception $exception) {
    
        // Unknown exception
        $body = new Stream(fopen('php://temp', 'r+'));
        $body->write($exception->getMessage());
        return $response->withStatus(500)->withBody($body);
    }
});
    
    */
}
