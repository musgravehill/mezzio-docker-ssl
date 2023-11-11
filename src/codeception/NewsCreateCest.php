<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Tests\Support\Step\Api\Oauth2;

class NewsCreateCest
{
    public function _before(Oauth2 $I)
    {
        //some
    }

    public function tryToTest(Oauth2 $I)
    {
        $I->auth();

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/news', [
            'title' => 'Title for news.',
            'text' => 'Text for news',
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //$I->seeResponseContains('title');
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'title' => 'string',
            'text' => 'string',
            'created' => 'string',
            'status' => 'string',
        ]);
    }
}
