<?php

namespace App\Tests\Api;

use \App\Tests\ApiTester;

class ProducersCest
{
    public function tryToGetProducer(ApiTester $I)
    {
        $I->haveInDatabase('producers', [
            'id' => 1,
            'name' => "Ryan Raynolds",
        ]);

        $I->sendGet('/producers');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Ryan Raynolds'
            ]
        ]);
    }

    public function tryToPostPatchDeleteProducer(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/producers', [
            'name' => 'Ryan Raynolds'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPatch("/producers/" . $response->id, [
            'name' => "Ryan"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Ryan"
        ]);

        $I->deleteHeader('Content-Type');
        $I->sendDelete("/producers/" . $response->id);
        $I->seeResponseCodeIs(204);
    }
}
