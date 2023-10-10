<?php

declare(strict_types=1);

namespace News\Factory;

use Laminas\InputFilter\InputFilterPluginManager;
use News\Contract\NewsServiceInterface;
use News\Handler\CreateHandler;
use News\InputFilter\CreateInputFilter;
use Psr\Container\ContainerInterface;

class CreateHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(CreateInputFilter::class);

        return new CreateHandler(
            newsService: $container->get(NewsServiceInterface::class),
            inputFilter: $inputFilter,
        );
    }
}
