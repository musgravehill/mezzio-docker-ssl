<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\AuthorizationServer;
use Oauth2\Middleware\AuthorizationEntrypointMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthorizationServerMiddlewareFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): AuthorizationEntrypointMiddleware {
        $responseFactory = $container->get(ResponseFactoryInterface::class);

        /**
         * @todo discover this code deeper
         */
        if (is_callable($responseFactory)) {
            $responseFactory = new CallableResponseFactoryDecorator(
                static fn (): ResponseInterface => $responseFactory()
            );
        }

        return new AuthorizationEntrypointMiddleware(
            authorizationServer: $container->get(AuthorizationServer::class),
            responseFactory: $responseFactory,
        );
    }
}
