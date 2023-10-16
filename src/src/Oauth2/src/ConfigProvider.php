<?php

declare(strict_types=1);

namespace Oauth2;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;
use Mezzio\Application;
use Oauth2\Factory\AuthCodeRepositoryFactory;
use Oauth2\Factory\AuthorizationEndpointMiddlewareFactory;
use Oauth2\Factory\AuthorizationServerFactory;
use Oauth2\Factory\AuthorizationEntrypointMiddlewareFactory;
use Oauth2\Factory\ProtectedResourceMiddlewareFactory;
use Oauth2\Factory\RefreshTokenRepositoryFactory;
use Oauth2\Factory\ResourceServerFactory;
use Oauth2\Factory\TokenEndpointMiddlewareFactory;
use Oauth2\Middleware\AuthorizationEndpointMiddleware;
use Oauth2\Middleware\AuthorizationEntrypointMiddleware;
use Oauth2\Middleware\ProtectedResourceMiddleware;
use Oauth2\Middleware\TokenEndpointMiddleware;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'    => $this->getDoctrine(),
            'oauth2_server_config' => $this->getOauth2ServerConfig(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                AuthCodeRepositoryInterface::class => AuthCodeRepositoryFactory::class,
                RefreshTokenRepositoryInterface::class => RefreshTokenRepositoryFactory::class,
                AuthorizationServer::class => AuthorizationServerFactory::class,
                AuthorizationEntrypointMiddleware::class => AuthorizationEntrypointMiddlewareFactory::class,
                AuthorizationEndpointMiddleware::class => AuthorizationEndpointMiddlewareFactory::class,
                TokenEndpointMiddleware::class => TokenEndpointMiddlewareFactory::class,
                ResourceServer::class => ResourceServerFactory::class,
                ProtectedResourceMiddleware::class => ProtectedResourceMiddlewareFactory::class,
            ],
        ];
    }

    /* 
        getcwd() may return false
        On some Unix variants, getcwd() will return false 
        if any one of the parent directories does not have the readable or search mode set, 
        even if the current directory does.
    */
    /**
     * @todo 'access_token_expire'  => 'PT10M', ?
     *   'refresh_token_expire' => 'PT10M', ?
     *   'auth_code_expire'     => 'PT10M', ? 
     */
    public function getOauth2ServerConfig(): array
    {
        return [
            'publicKeyPath' => 'file://' . __DIR__ . '/../key/public.key',
            'privateKeyPath' => 'file://' . __DIR__ . '/../key/private.key',
            'encryptionKey' => 'def00000650ec376ed0da2b2b9567d81e297422e0fb4138f1dfef22c4339daae1fa1f5e9bc3cba03a942ac7ccc04b5cc5d6cca953939f0cb7cdbca9542d3cb8dd2d316b3',
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getDoctrine(): array
    {
        return [
            'driver'     => [
                'attribute'   => [
                    'paths' => [
                        __DIR__ . '/Entity',
                    ],
                ],
                'orm_default' => [
                    'drivers' => [
                        'Oauth2\Entity' => 'attribute',
                    ],
                ],
            ],
            'migrations' => [
                'orm_default' => [
                    'migrations_paths' => [
                        'Oauth2\Migrations' => __DIR__ . '/../migrations',
                    ],
                ],
            ],
        ];
    }
}
