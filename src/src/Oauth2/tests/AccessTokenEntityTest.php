<?php

declare(strict_types=1);

namespace Oauth2\tests;

use Oauth2\Entity\AccessTokenEntity;
use Oauth2\Entity\ClientEntity;
use Oauth2\Entity\ScopeEntity;
use Oauth2\tests\Builder\ClientEntityBuilder;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Oauth2\tests\Trait\assertEqualsDeep;

final class AccessTokenEntityTest extends TestCase
{
    use assertEqualsDeep;

    public function testCreate(): void
    {
        $clientEntity = (new ClientEntityBuilder())->withClientPublic()->build();

        $scopeIdentifier = 'full';
        $scopes = [new ScopeEntity($scopeIdentifier)];

        $userIdentifier = 'ebe474a0-45b9-40ef-ad96-dde9bca5e19e';

        $accessTokenEntity = new AccessTokenEntity(
            $clientEntity,
            $scopes,
            $userIdentifier
        );

        $this->assertEqualsDeep($clientEntity, $accessTokenEntity->getClient());
        $this->assertInstanceOf(ClientEntityInterface::class, $accessTokenEntity);
    }
}
