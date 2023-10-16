<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use Oauth2\Repository\RefreshTokenRepository;

/*
    no way! $em->getRepository(RefreshTokenEntity::class) return NOT RefreshTokenEntityInterface, return Doctrine\ORM\EntityRepository
*/
//#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]

#[ORM\Entity]
#[ORM\Table(name: 'oauth2_refresh_token')]
class RefreshTokenEntity implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait;
    use EntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
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

    // custom param. getRefreshTokensByUser - "logout from all devicies"
    #[ORM\Column(type: 'uuid', nullable: false)]
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
