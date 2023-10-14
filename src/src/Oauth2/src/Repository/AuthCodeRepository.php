<?php

declare(strict_types=1);

namespace Oauth2\Repository;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Oauth2\Entity\AuthCodeEntity;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<AuthCodeEntity>
 */
class AuthCodeRepository extends EntityRepository implements AuthCodeRepositoryInterface  
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        // Some logic to persist the auth code to a database
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        // Some logic to revoke the auth code in a database
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        return false;  //todo expire dt?
    }

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }
}
