<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserEntity implements UserEntityInterface
{
    /**
     * @param UuidInterface $identifier 
     */
    public function __construct(private readonly UuidInterface $identifier)
    {
    }

    public function getIdentifier(): mixed
    {
        return $this->identifier;
    }
}
