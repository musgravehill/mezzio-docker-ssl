<?php

declare(strict_types=1);

namespace Oauth2\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Oauth2\Entity\AuthCodeEntity;

/*
    no way! $em->getRepository(AuthCodeEntity::class) return NOT AuthCodeRepositoryInterface, return Doctrine\ORM\EntityRepository 
    use Doctrine\ORM\EntityRepository;
    @extends EntityRepository<AuthCodeEntity> 
    extends EntityRepository
*/

class AuthCodeRepository implements AuthCodeRepositoryInterface
{

    /**
     * @param EntityRepository<AuthCodeEntity> $repo  
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EntityRepository $repo
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        try {
            $this->em->persist($authCodeEntity);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        $authCodeEntity = $this->repo->find($codeId);
        if(is_null($authCodeEntity)){
            return;
        }
        $this->em->remove($authCodeEntity);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        return is_null($this->repo->find($codeId));
    }

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }

    public function getAuthCodes()
    {
        return $this->repo->findAll();
    }
}
