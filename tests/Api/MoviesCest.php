<?php

namespace App\Tests\Api;

use \App\Tests\ApiTester;

class MoviesCest
{
    public function tryToGetMovie(ApiTester $I)
    {
        $I->haveInDatabase('movies', [
            'id' => 1,
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2022,
            'duration' => 120,
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);

        $I->sendGet('/movies');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'title' => 'Raya And The Last Dragon'
            ]
        ]);
    }

    public function tryToPostMovie(ApiTester $I)
    {
        $data = [
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2022,
            'duration' => 120,
            'createdAt' => "2022-02-21T16:47:20+00:00",
            'updatedAt' => "2022-02-21T16:47:20+00:00"
        ];

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/movies', $data);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            "title" => 'string'
        ]);
    }
}
