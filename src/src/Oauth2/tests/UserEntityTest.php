<?php

declare(strict_types=1);

namespace Oauth2\tests;

use Oauth2\Entity\UserEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserEntityTest extends TestCase
{
    public function testCreate(): void
    {
        $identifier = Uuid::uuid4()->toString();
        $user = new UserEntity($identifier);
        $this->assertEquals($identifier, $user->getIdentifier());
    }
}
