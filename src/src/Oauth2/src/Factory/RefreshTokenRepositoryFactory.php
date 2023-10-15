<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Oauth2\Entity\RefreshTokenEntity;
use Oauth2\Repository\RefreshTokenRepository;
use Psr\Container\ContainerInterface;

class RefreshTokenRepositoryFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): RefreshTokenRepositoryInterface {
        $em = $container->get(EntityManagerInterface::class);
        return new RefreshTokenRepository(
            em: $em,
            repo: $em->getRepository(RefreshTokenEntity::class),
        );
    }
}
