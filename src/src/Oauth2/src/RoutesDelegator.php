<?php

declare(strict_types=1);

namespace Oauth2;

use Mezzio\Application;
use Psr\Container\ContainerInterface;
use Oauth2\Middleware\AuthorizationEntrypointMiddleware;
use Oauth2\Middleware\AuthorizationEndpointMiddleware;
use Oauth2\Middleware\TokenEndpointMiddleware;

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
            // $authRequest->setAuthorizationApproved(true); or False if user decline (not approve)
            // AuthorizationUserMiddleware::class,

            AuthorizationEndpointMiddleware::class,

        ], ['GET', 'POST']);

        $app->post('/oauth2/token', TokenEndpointMiddleware::class);

        return $app;
    }
}
