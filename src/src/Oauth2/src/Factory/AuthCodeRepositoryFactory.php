<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Oauth2\Entity\AuthCodeEntity;
use Oauth2\Repository\AuthCodeRepository;
use Psr\Container\ContainerInterface;

class AuthCodeRepositoryFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): AuthCodeRepositoryInterface {
        $em = $container->get(EntityManagerInterface::class);
        return new AuthCodeRepository(
            em: $em,
            repo: $em->getRepository(AuthCodeEntity::class),
        );
    }
}
