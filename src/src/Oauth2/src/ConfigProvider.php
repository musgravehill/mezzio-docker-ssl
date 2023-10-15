<?php

declare(strict_types=1);

namespace Oauth2;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Mezzio\Application;
use Oauth2\Factory\AuthCodeRepositoryFactory;
use Oauth2\Factory\AuthorizationServerFactory;
use Oauth2\Factory\RefreshTokenRepositoryFactory;

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
            'delegators' => [],
            'factories'  => [
                AuthCodeRepositoryInterface::class => AuthCodeRepositoryFactory::class,
                RefreshTokenRepositoryInterface::class => RefreshTokenRepositoryFactory::class,
                AuthorizationServer::class => AuthorizationServerFactory::class,
            ],

        ];
    }

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