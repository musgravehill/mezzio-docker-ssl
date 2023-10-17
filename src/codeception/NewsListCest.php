<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Tests\Support\Step\Api\Oauth2;

class NewsListCest
{
    public function _before(Oauth2 $I)
    {
    }

    public function tryToTest(Oauth2 $I)
    {
        $I->auth();

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/news', [
            'page' => 1,
            'limit' => 3,
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //$I->seeResponseContains('title');
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'title' => 'string',
            'text' => 'string',
            'created' => 'string'
        ], '$.[0]'); // JsonPath 
    }
}
