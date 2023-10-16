<?php

declare(strict_types=1);

namespace Oauth2\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class ClientEntity implements ClientEntityInterface
{
    use EntityTrait;
    use ClientTrait;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|string[]
     */
    protected $redirectUri;

    /**
     * @var bool
     */
    protected $isConfidential = false;

    public function __construct(string $identifier, string $name, string|array $redirectUri, bool $isConfidential)
    {
        $this->setIdentifier($identifier);
        $this->setName($name);
        $this->setRedirectUri($redirectUri);
        $this->setConfidential($isConfidential);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }

    public function setConfidential(bool $isConfidential)
    {
        $this->isConfidential = $isConfidential;
    }
}
