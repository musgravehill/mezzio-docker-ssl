<?php

declare(strict_types=1);

namespace Oauth2\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Oauth2\Entity\RefreshTokenEntity;

/*
    no way! $em->getRepository(RefreshTokenEntity::class) return NOT RefreshTokenRepositoryInterface, return Doctrine\ORM\EntityRepository
    use Doctrine\ORM\EntityRepository;
    @extends EntityRepository<RefreshTokenEntity>
    extends EntityRepository
*/

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @param EntityRepository<RefreshTokenEntity> $repo
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EntityRepository $repo
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        try {
            $this->em->persist($refreshTokenEntity);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        $refreshTokenEntity = $this->repo->find($tokenId);
        if (is_null($refreshTokenEntity)) {
            return;
        }
        $this->em->remove($refreshTokenEntity);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return is_null($this->repo->find($tokenId));
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
}
