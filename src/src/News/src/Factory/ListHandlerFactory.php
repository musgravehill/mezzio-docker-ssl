<?php

declare(strict_types=1);

namespace News\Factory;

use Laminas\InputFilter\InputFilterPluginManager;
use News\Contract\NewsServiceInterface;
use News\Handler\ListHandler;
use News\InputFilter\ListInputFilter;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(ListInputFilter::class);

        return new ListHandler(
            newsService: $container->get(NewsServiceInterface::class),
            inputFilter: $inputFilter,
        );
    }
}
