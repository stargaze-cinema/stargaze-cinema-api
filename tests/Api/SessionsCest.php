<?php

declare(strict_types=1);

namespace App\Tests\Api;

use \App\Tests\ApiTester;

class SessionsCest
{
    public function tryToGetSession(ApiTester $I): void
    {
        $I->haveInDatabase('sessions', [
            'id' => 1,
            'movie_id' => 1,
            'hall_id' => 1,
            'begin_at' => date('Y-m-d H:i:s', time()),
            'end_at' => date('Y-m-d H:i:s', time())
        ]);

        $I->sendGet('/sessions');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Lunar'
            ]
        ]);
    }

    public function tryToPostPatchDeleteSession(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
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
        $I->haveInDatabase('halls', [
            'id' => 1,
            'name' => "Lunar",
            'capacity' => 100,
            'type' => 'IMAX',
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendPost('/sessions', [
            'movie_id' => 1,
            'hall_id' => 1,
            'begin_at' => date('Y-m-d H:i:s', time()),
            'end_at' => date('Y-m-d H:i:s', time())
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPatch("/sessions/" . $response->id, [
            'name' => "Stargaze"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Stargaze"
        ]);

        $I->deleteHeader('Content-Type');
        $I->sendDelete("/sessions/" . $response->id);
        $I->seeResponseCodeIs(204);
    }
}
