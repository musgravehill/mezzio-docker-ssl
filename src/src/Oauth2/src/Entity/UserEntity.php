<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserEntity implements UserEntityInterface
{
    /**
     * @param string|int|null
     */
    public function __construct(private readonly string|int|null $identifier)
    {
    }

    public function getIdentifier(): string|int|null
    {
        return $this->identifier;
    }
}
