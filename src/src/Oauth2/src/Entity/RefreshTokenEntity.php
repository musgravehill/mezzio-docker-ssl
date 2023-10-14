<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

//#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: 'oauth2_refresh_token')]
class RefreshTokenEntity implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 80)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    /**
     * @var string
     */
    protected $identifier;

    #[ORM\Column(type: 'datetime_immutable')]
    /**
     * @var DateTimeImmutable
     */
    protected $expiryDateTime;

    #[ORM\Column(type: 'uuid', nullable: false)]
    /**
     * @var string|int|null
     */
    private ?string $userIdentifier = null;

    /**
     * {@inheritdoc}
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->userIdentifier = strval($accessToken->getUserIdentifier());
    }
}
