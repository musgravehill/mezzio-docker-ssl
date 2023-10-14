<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use Doctrine\ORM\Mapping as ORM;

//#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: 'oauth2_auth_code')]
class AuthCodeEntity implements AuthCodeEntityInterface
{
    use EntityTrait, TokenEntityTrait, AuthCodeTrait;

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
    protected $userIdentifier;


}
