<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\ApiTester;

class HallsCest
{
    public function tryToGetHall(ApiTester $I): void
    {
        $I->haveInDatabase('halls', [
            'id' => 3,
            'name' => "Moon",
            'capacity' => 100,
            'type' => 'IMAX',
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);

        $I->sendGet('/halls');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Moon'
            ]
        ]);
    }

    public function tryToGetInvalidHall(ApiTester $I): void
    {
        $I->sendGet('/halls/420');
        $I->seeResponseCodeIs(404);
    }

    public function tryToPostHall(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/halls', [
            'name' => "Moon",
            'capacity' => 100,
            'type' => 'IMAX'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidHall(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/halls', [
            'name' => "Moon",
            'type' => 'IMAX'
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
    }

    public function tryToPatchHall(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveInDatabase('halls', [
            'id' => 3,
            'name' => "Moon",
            'capacity' => 100,
            'type' => 'IMAX',
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendPatch("/halls/3", [
            'name' => "Star"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Star"
        ]);
    }

    public function tryToDeleteHall(ApiTester $I): void
    {
        $I->haveInDatabase('halls', [
            'id' => 3,
            'name' => "Moon",
            'capacity' => 100,
            'type' => 'IMAX',
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendDelete("/halls/3");
        $I->seeResponseCodeIs(204);
    }
}
