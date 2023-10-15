<?php

declare(strict_types=1);

namespace Oauth2;

use Oauth2\Middleware\AuthorizationServerMiddleware;
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

        $app->get('/authorize', [
            AuthorizationServerMiddleware::class
        ]);

        return $app;
    }
}
