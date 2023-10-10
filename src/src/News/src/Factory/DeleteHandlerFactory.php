<?php

declare(strict_types=1);

namespace News\Factory;

use Laminas\InputFilter\InputFilterPluginManager;
use News\Contract\NewsServiceInterface;
use News\Handler\DeleteHandler;
use News\InputFilter\DeleteInputFilter;
use Psr\Container\ContainerInterface;

class DeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(DeleteInputFilter::class);

        return new DeleteHandler(
            newsService: $container->get(NewsServiceInterface::class),
            inputFilter: $inputFilter,
        );
    }
}
