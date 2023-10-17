<?php

namespace Tests\Api;

use Tests\Support\ApiTester;

class ListNewsCest
{
    const authorizeUrl = 'https://x.not-real.ru/oauth2/authorize?response_type=code&client_id=a8fdfb18-9293-4f37-aad2-a52bb383204b&redirect_uri=https://x.not-real.ru&scope=full&client_secret=47e2f77d-a04e-4e08-b627-ba67b9c3d987&state=';
    const tokenUrl = 'https://x.not-real.ru/oauth2/token'; //POST x-www-form-urlencoded
    private ?string $token = null;

    public function _before(ApiTester $I)
    {
        $I->sendGet(self::authorizeUrl);
        $responseAuth = json_decode($I->grabResponse(), true);
        $code = $responseAuth['code'] ?? null;

        $I->sendPost(self::tokenUrl, [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => 'a8fdfb18-9293-4f37-aad2-a52bb383204b',
            'client_secret' => '47e2f77d-a04e-4e08-b627-ba67b9c3d987',
            'redirect_uri' => 'https://x.not-real.ru',
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
    }

    public function tryToTest(ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/news', [
            'page' => 1,
            'limit' => 3,
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContains('title');
    }
}
