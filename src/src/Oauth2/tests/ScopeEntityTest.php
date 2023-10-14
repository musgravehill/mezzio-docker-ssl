<?php

declare(strict_types=1);

namespace Oauth2\tests;

use Oauth2\Entity\ScopeEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ScopeEntityTest extends TestCase
{
    public function testCreate(): void
    {
        $identifier = 'full';
        $scope = new ScopeEntity($identifier);
        $this->assertEquals($identifier, $scope->getIdentifier());
        $this->assertEquals($identifier, $scope->jsonSerialize());
    }
}
