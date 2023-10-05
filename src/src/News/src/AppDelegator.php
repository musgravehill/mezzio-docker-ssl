<?php

declare(strict_types=1);

namespace News;

use Mezzio\Application;
use Mezzio\Authentication\AuthenticationMiddleware;
use Psr\Container\ContainerInterface;

/**
 * This class is designed for experimentation.
 */
class AppDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        //echo print_r($callback);
        //die;

        /** @var Application $app */
        $app = $callback();        

        return $app;
    }
}
