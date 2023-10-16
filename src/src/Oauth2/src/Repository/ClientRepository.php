<?php

declare(strict_types=1);

namespace Oauth2\Repository;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Oauth2\Entity\ClientEntity;

/**
 * @todo ClientRepository: pull client from .env or config for: prod, dev, test, local envs
 */
class ClientRepository implements ClientRepositoryInterface
{
    private readonly array $clients;

    public function __construct()
    {
        /**
         * @todo before persist client password_hash('47e2f77d-a04e-4e08-b627-ba67b9c3d987', PASSWORD_BCRYPT);
         */
        $this->clients = [
            '09aac9b1-f9e1-44b4-9381-9255451a3ad0' => [
                'name' => 'Client app vue',
                'redirectUri' => 'https://oauth.pstmn.io/v1/vscode-callback',
                'isConfidential' => false,
                'clientSecretHash' => null,
            ],
            'a8fdfb18-9293-4f37-aad2-a52bb383204b' => [
                'name' => 'Client app server',
                'redirectUri' => getenv('OAUTH2_REDIR_URI'),
                'isConfidential' => true,
                'clientSecretHash' => password_hash('47e2f77d-a04e-4e08-b627-ba67b9c3d987', PASSWORD_BCRYPT),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier)
    {
        if (\array_key_exists($clientIdentifier, $this->clients) === false) {
            return null;
        }

        $client = new ClientEntity(
            identifier: $clientIdentifier,
            name: $this->clients[$clientIdentifier]['name'],
            redirectUri: $this->clients[$clientIdentifier]['redirectUri'],
            isConfidential: $this->clients[$clientIdentifier]['isConfidential'],
        );

        /*
        move this to __construct
        $client->setIdentifier($clientIdentifier);
        $client->setName(self::CLIENT_NAME);
        $client->setRedirectUri(self::REDIRECT_URI);
        $client->setConfidential();
        */

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $client = $this->getClientEntity($clientIdentifier);
        if (is_null($client)) {
            return false;
        }

        if (
            $client->isConfidential() === true
            && \password_verify($clientSecret, $this->clients[$clientIdentifier]['clientSecretHash']) === false
        ) {
            return false;
        }

        return true;
    }
}
