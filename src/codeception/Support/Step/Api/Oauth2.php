<?php

declare(strict_types=1);

namespace Tests\Support\Step\Api;

class Oauth2 extends \Tests\Support\ApiTester
{
    const authorizeUrl = 'https://x.not-real.ru/oauth2/authorize?response_type=code&client_id=a8fdfb18-9293-4f37-aad2-a52bb383204b&redirect_uri=https://x.not-real.ru/oauth2/result&scope=full&client_secret=47e2f77d-a04e-4e08-b627-ba67b9c3d987&state=';
    const tokenUrl = 'https://x.not-real.ru/oauth2/token'; //POST x-www-form-urlencoded
    private ?string $token = null;

    public function auth()
    {
        $I = $this;
        $I->sendGet(self::authorizeUrl);
        $responseAuth = json_decode($I->grabResponse(), true);
        $code = $responseAuth['code'] ?? null;

        $I->sendPost(self::tokenUrl, [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => 'a8fdfb18-9293-4f37-aad2-a52bb383204b',
            'client_secret' => '47e2f77d-a04e-4e08-b627-ba67b9c3d987',
            'redirect_uri' => 'https://x.not-real.ru/oauth2/result',
        ]);
        $responseToken = json_decode($I->grabResponse(), true);
        /*
        "token_type": "Bearer",
        "expires_in": 6000,
        "access_token": "",
        "refresh_token": 
        */
        $access_token = $responseToken['access_token'] ?? null;
        $this->token = $access_token;

        $I->amBearerAuthenticated($this->token);
    }
}
