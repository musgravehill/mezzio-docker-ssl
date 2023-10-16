<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait;
    use TokenEntityTrait;
    use EntityTrait;

    public function __construct(ClientEntityInterface $clientEntity, array $scopes, string|int|null $userIdentifier = null)
    {
        $this->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $this->addScope($scope);
        }
        $this->setUserIdentifier($userIdentifier);
    }
}
