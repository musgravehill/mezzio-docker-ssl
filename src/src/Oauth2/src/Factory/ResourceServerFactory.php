<?php

declare(strict_types=1);

namespace Oauth2\Factory;

use Defuse\Crypto\Key;
use Laminas\ServiceManager\Factory\FactoryInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;
use Oauth2\Repository\AccessTokenRepository;
use Oauth2\Repository\ClientRepository;
use Oauth2\Repository\ScopeRepository;
use Psr\Container\ContainerInterface;
use UnexpectedValueException;

class ResourceServerFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ResourceServer {

        $accessTokenRepository = new AccessTokenRepository();
        $server = new ResourceServer(
            accessTokenRepository: $accessTokenRepository,
            publicKey: $this->getPublicKey($container),
            authorizationValidator: null,
        );

        return $server;
    }

    protected function getPublicKey(ContainerInterface $container): string
    {
        $config = $container->get('config')['oauth2_server_config'] ?? [];
        if (!isset($config['publicKeyPath']) || empty($config['publicKeyPath'])) {
            throw new UnexpectedValueException(
                'The publicKeyPath value is missing in config'
            );
        }
        return $config['publicKeyPath'];
    }
}
