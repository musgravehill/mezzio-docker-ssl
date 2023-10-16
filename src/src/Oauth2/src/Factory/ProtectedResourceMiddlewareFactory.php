<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\ResourceServer;
use Oauth2\Middleware\ProtectedResourceMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class ProtectedResourceMiddlewareFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ProtectedResourceMiddleware {
        $responseFactory = $container->get(ResponseFactoryInterface::class);

        /**
         * @todo discover this code deeper
         */
        /*
        if (is_callable($responseFactory)) {
            $responseFactory = new CallableResponseFactoryDecorator(
                static fn (): ResponseInterface => $responseFactory()
            );
        }
        */

        return new ProtectedResourceMiddleware(
            resourceServer: $container->get(ResourceServer::class),
            responseFactory: $responseFactory,
        );
    }
}
