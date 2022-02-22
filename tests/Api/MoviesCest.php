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
            'year' => 2021,
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

    public function tryToPostPatchDeleteMovie(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/movies', [
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 120
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPatch("/movies/" . $response->id, [
            'description' => "Some updated text."
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'description' => "Some updated text."
        ]);

        $I->deleteHeader('Content-Type');
        $I->sendDelete("/movies/" . $response->id);
        $I->seeResponseCodeIs(204);
    }
}
