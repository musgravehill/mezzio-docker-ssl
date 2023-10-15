<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\AuthorizationServer;
use Oauth2\Middleware\AuthorizationServerMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthorizationServerMiddlewareFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): AuthorizationServerMiddleware {
        return new AuthorizationServerMiddleware(
            authorizationServer: $container->get(AuthorizationServer::class),
            responseFactory: $container->get(ResponseFactoryInterface::class)
        );
    }
}