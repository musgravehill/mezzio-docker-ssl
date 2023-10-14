<?php

declare(strict_types=1);

namespace Oauth2\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Oauth2\Entity\UserEntity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        if ($username === 'alex' && $password === 'whisky') {
            return new UserEntity(Uuid::uuid4());
        }

        return;
    }
}
