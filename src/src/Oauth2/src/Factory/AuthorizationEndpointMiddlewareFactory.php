<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\AuthorizationServer;
use Oauth2\Middleware\AuthorizationEndpointMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthorizationEndpointMiddlewareFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): AuthorizationEndpointMiddleware {
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

        return new AuthorizationEndpointMiddleware(
            authorizationServer: $container->get(AuthorizationServer::class),
            responseFactory: $responseFactory,
        );
    }
}
