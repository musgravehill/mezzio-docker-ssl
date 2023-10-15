<?php

declare(strict_types=1);

namespace App\Handler;

use DateInterval;
use DateTimeImmutable;
use Laminas\Diactoros\Response\JsonResponse;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Oauth2\Entity\ClientEntity;
use Oauth2\Repository\AuthCodeRepository;
use Oauth2\Repository\RefreshTokenRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function time;

class PingHandler implements RequestHandlerInterface
{
    public function __construct(ContainerInterface $container)
    {
        /**
         * @var AuthCodeRepository|AuthCodeRepositoryInterface $AuthCodeRepository
         */
        $AuthCodeRepository = $container->get(AuthCodeRepositoryInterface::class);

        /*
        $AuthCode = $AuthCodeRepository->getNewAuthCode();
        $client = new ClientEntity('1', 'myApp', 'https://x.not-real.ru/some', false);
        $AuthCode->setClient($client);
        $AuthCode->setExpiryDateTime((new DateTimeImmutable())->add(new DateInterval('P1D')));
        $AuthCode->setIdentifier('authcode2');
        $AuthCode->setRedirectUri('https://x.not-real.ru/some');
        $AuthCode->setUserIdentifier('ebe474a0-45b9-40ef-ad96-dde9bca5e19e');
        $AuthCodeRepository->persistNewAuthCode($AuthCode);
        */

        print_r($AuthCodeRepository->getAuthCodes());



        /**
         * @var RefreshTokenRepository|RefreshTokenRepositoryInterface $RefreshTokenRepository
         */
        $RefreshTokenRepository = $container->get(RefreshTokenRepositoryInterface::class);
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //$AuthCodeRepository = new AuthCodeRepository()
        return new JsonResponse(['ack' => time()]);
    }
}
