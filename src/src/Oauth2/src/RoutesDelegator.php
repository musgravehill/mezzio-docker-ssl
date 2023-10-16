<?php

declare(strict_types=1);

namespace Oauth2;

use Oauth2\Middleware\AuthorizationEntrypointMiddleware;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

/**
 * Routes specific to the Notification module
 */
class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->route('/oauth2/authorize', [
            // SessionMiddleware? 

            AuthorizationEntrypointMiddleware::class,

            /**
             * @todo 
             * login User
             * ask the User to approve the client and the scopes requested
             */
            // $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface          
            // $authRequest->setAuthorizationApproved(true);
            AuthorizationUserMiddleware::class,

            /**
             * @todo 
             * return $server->completeAuthorizationRequest($authRequest, $response);
             */
            AuthorizationEndpointMiddleware::class,

        ], ['GET', 'POST']);

        $app->route('/oauth2/authorize', [
            // SessionMiddleware? 

            AuthorizationEntrypointMiddleware::class,

            /**
             * @todo 
             * login User
             * ask the User to approve the client and the scopes requested
             */
            // $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface          
            // $authRequest->setAuthorizationApproved(true);
            AuthorizationUserMiddleware::class,

            /**
             * @todo 
             * return $server->completeAuthorizationRequest($authRequest, $response);
             */
            AuthorizationEndpointMiddleware::class,

        ], ['GET', 'POST']);

        /**
         * @todo $this->server->respondToAccessTokenRequest($request, $response) 
         */
        $app->post('/oauth2/token', TokenEndpointHandler::class);

        return $app;
    }
}
