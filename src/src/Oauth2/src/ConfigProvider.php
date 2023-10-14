<?php

declare(strict_types=1);

namespace Oauth2;

use Mezzio\Application;

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
            'factories'  => [],

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
