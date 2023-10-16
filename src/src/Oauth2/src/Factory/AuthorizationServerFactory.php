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
use Oauth2\Repository\AccessTokenRepository;
use Oauth2\Repository\ClientRepository;
use Oauth2\Repository\ScopeRepository;
use Psr\Container\ContainerInterface;
use UnexpectedValueException;

class AuthorizationServerFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): AuthorizationServer {

        $clientRepository = new ClientRepository();
        $accessTokenRepository = new AccessTokenRepository();
        $scopeRepository = new ScopeRepository();
        $authCodeRepository = $container->get(AuthCodeRepositoryInterface::class);
        $refreshTokenRepository = $container->get(RefreshTokenRepositoryInterface::class);

        $server = new AuthorizationServer(
            clientRepository: $clientRepository,
            accessTokenRepository: $accessTokenRepository,
            scopeRepository: $scopeRepository,
            privateKey: $this->getPrivateKey($container),
            encryptionKey: $this->getEncryptionKey($container),
            responseType: null
        );

        // Enable the authentication code grant on the server with a token TTL
        $server->enableGrantType(
            grantType: new AuthCodeGrant(
                authCodeRepository: $authCodeRepository,
                refreshTokenRepository: $refreshTokenRepository,
                authCodeTTL: new \DateInterval('PT100M')
            ),
            accessTokenTTL: new \DateInterval('PT100M')
        );

        // Enable the refresh token grant on the server with a token TTL
        $server->enableGrantType(
            grantType: new RefreshTokenGrant($refreshTokenRepository),
            accessTokenTTL: new \DateInterval('PT100M')
        );

        $server->enableGrantType(
            grantType: new ClientCredentialsGrant(),
            accessTokenTTL: new \DateInterval('PT100M')
        );


        return $server;
    }

    protected function getPrivateKey(ContainerInterface $container): string
    {
        $config = $container->get('config')['oauth2_server_config'] ?? [];
        if (!isset($config['privateKeyPath']) || empty($config['privateKeyPath'])) {
            throw new UnexpectedValueException(
                'The privateKeyPath value is missing in config'
            );
        }
        return  $config['privateKeyPath'];
    }

    protected function getEncryptionKey(ContainerInterface $container): Key
    {
        $config = $container->get('config')['oauth2_server_config'] ?? [];
        if (!isset($config['encryptionKey']) || empty($config['encryptionKey'])) {
            throw new UnexpectedValueException(
                'The encryptionKey value is missing in config'
            );
        }
        return Key::loadFromAsciiSafeString($config['encryptionKey']);
    }
}
