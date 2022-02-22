<?php

namespace App\Tests\Api;

use \App\Tests\ApiTester;

class HallsCest
{
    public function tryToGetHall(ApiTester $I)
    {
        $I->haveInDatabase('halls', [
            'id' => 1,
            'name' => "Lunar",
            'capacity' => 100,
            'type' => 'IMAX'
        ]);

        $I->sendGet('/halls');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Lunar'
            ]
        ]);
    }

    public function tryToPostPatchDeleteHall(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/halls', [
            'name' => 'Lunar',
            'capacity' => 100,
            'type' => 'IMAX'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPatch("/halls/" . $response->id, [
            'name' => "Stargaze"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Stargaze"
        ]);

        $I->deleteHeader('Content-Type');
        $I->sendDelete("/halls/" . $response->id);
        $I->seeResponseCodeIs(204);
    }
}
