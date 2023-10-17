<?php

declare(strict_types=1);

namespace Oauth2\tests;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use Oauth2\Entity\AccessTokenEntity;
use Oauth2\Entity\ClientEntity;
use Oauth2\Entity\ScopeEntity;
use Oauth2\tests\Builder\ClientEntityBuilder;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Oauth2\tests\Trait\assertEqualsDeepTrait;

final class AccessTokenEntityTest extends TestCase
{
    use assertEqualsDeepTrait;  // ->assertEqualsDeep

    public function testClientPublic(): void
    {
        $clientEntity = (new ClientEntityBuilder())->withClientPublic()->build();

        $scopeIdentifier = 'full';
        $scopes = [new ScopeEntity($scopeIdentifier),];

        $userIdentifier = 'ebe474a0-45b9-40ef-ad96-dde9bca5e19e';

        $accessTokenEntity = new AccessTokenEntity(
            $clientEntity,
            $scopes,
            $userIdentifier
        );     

        $this->assertEqualsDeep($clientEntity, $accessTokenEntity->getClient());
        $this->assertInstanceOf(AccessTokenEntityInterface::class, $accessTokenEntity);         
    }

    public function testClientConfidential(): void
    {
        $clientEntity = (new ClientEntityBuilder())->withClientConfidential()->withName('appMachineMachine')->build();

        $scopeIdentifier = 'full';
        $scopes = [new ScopeEntity($scopeIdentifier),];

        $userIdentifier = 'ebe474a0-45b9-40ef-ad96-dde9bca5e19e';

        $accessTokenEntity = new AccessTokenEntity(
            $clientEntity,
            $scopes,
            $userIdentifier
        );     

        $this->assertEqualsDeep($clientEntity, $accessTokenEntity->getClient());
        $this->assertInstanceOf(AccessTokenEntityInterface::class, $accessTokenEntity);         
    }
}
