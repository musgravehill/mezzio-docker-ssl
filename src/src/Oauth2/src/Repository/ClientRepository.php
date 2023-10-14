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
    // simple 1 client harcoded here 
    const clientIdentifier = '09aac9b1-f9e1-44b4-9381-9255451a3ad0';

    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier)
    {
        if (self::clientIdentifier <> $clientIdentifier) {
            return null;
        }
        $client = new ClientEntity(
            identifier: $clientIdentifier,
            name: 'Client app ' . self::clientIdentifier,
            redirectUri: getenv('OAUTH2_REDIR_URI'),
            isConfidential: false,
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
        if (is_null($this->getClientEntity($clientIdentifier))) {
            return false;
        }
        
        // you can check the $clientSecret if client is confidential 
        // and works with $grantType
        /*
        $clients = [
            'myawesomeapp' => [
                'secret'          => \password_hash('abc123', PASSWORD_BCRYPT),
                'name'            => self::CLIENT_NAME,
                'redirect_uri'    => self::REDIRECT_URI,
                'is_confidential' => true,
            ],
        ];

        // Check if client is registered
        if (\array_key_exists($clientIdentifier, $clients) === false) {
            return false;
        }

        if (
            $clients[$clientIdentifier]['is_confidential'] === true
            && \password_verify($clientSecret, $clients[$clientIdentifier]['secret']) === false
        ) {
            return false;
        }
        */

        return true;
    }
}
