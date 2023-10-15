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
        if ($username === 'Goran' && $password === 'Bregovic') {
            return new UserEntity(Uuid::fromString('ebe474a0-45b9-40ef-ad96-dde9bca5e19e')->toString());
        }

        return;
    }
}
