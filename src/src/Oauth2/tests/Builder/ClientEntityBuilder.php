<?php

declare(strict_types=1);

namespace Oauth2\tests\Builder;

use Oauth2\Entity\ClientEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Oauth2\Entity\ScopeEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ClientEntityBuilder
{
    private string $identifier = '09aac9b1-f9e1-44b4-9381-9255451a3ad0';
    private string $name = 'myApp';
    private string|array $redirectUri = 'https://x.not-real.ru';
    private bool $isConfidential = false;

    public function build(): ClientEntityInterface
    {
        $clientEntity = new ClientEntity(
            identifier: $this->identifier,
            name: $this->name,
            redirectUri: $this->redirectUri,
            isConfidential: $this->isConfidential,
        );
        return $clientEntity;
    }

    public function withName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function withClientConfidential(): self
    {
        $this->identifier = 'a8fdfb18-9293-4f37-aad2-a52bb383204b';
        $this->name = 'clientConfidential';
        $this->redirectUri = 'https://x.not-real.ru';
        $this->isConfidential = true;
        return $this;
    }

    public function withClientPublic(): self
    {
        $this->identifier = '09aac9b1-f9e1-44b4-9381-9255451a3ad0';
        $this->name = 'clientPublic';
        $this->redirectUri = 'https://x.not-real.ru';
        $this->isConfidential = false;
        return $this;
    }
}
