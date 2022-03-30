<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\ApiTester;

class ProducersCest
{
    public function tryToGetProducer(ApiTester $I): void
    {
        $I->haveInDatabase('producers', [
            'id' => 1,
            'name' => "Ryan Raynolds",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
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

    public function tryToGetInvalidProducer(ApiTester $I): void
    {
        $I->sendGet('/producers/420');
        $I->seeResponseCodeIs(404);
    }

    public function tryToPostProducer(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/producers', [
            'name' => "Ryan Raynolds",
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidProducer(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/producers', [
            'name' => 422,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
    }

    public function tryToPatchProducer(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveInDatabase('producers', [
            'id' => 3,
            'name' => "Ryan Raynolds",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendPatch("/producers/3", [
            'name' => "Star Raynolds"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Star Raynolds"
        ]);
    }

    public function tryToDeleteProducer(ApiTester $I): void
    {
        $I->haveInDatabase('producers', [
            'id' => 3,
            'name' => "Moon",
            'capacity' => 100,
            'type' => 'IMAX',
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendDelete("/producers/3");
        $I->seeResponseCodeIs(204);
    }
}
