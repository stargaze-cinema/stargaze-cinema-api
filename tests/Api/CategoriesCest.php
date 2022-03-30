<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\ApiTester;

class CategoriesCest
{
    public function tryToGetCategory(ApiTester $I): void
    {
        $I->haveInDatabase('categories', [
            'id' => 1,
            'name' => "Action",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);

        $I->sendGet('/categories');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Action'
            ]
        ]);
    }

    public function tryToGetInvalidCategory(ApiTester $I): void
    {
        $I->sendGet('/categories/420');
        $I->seeResponseCodeIs(404);
    }

    public function tryToPostCategory(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/categories', [
            'name' => 'Action'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidCategory(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/categories', [
            'name' => true
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
    }

    public function tryToPatchCategory(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveInDatabase('categories', [
            'id' => 3,
            'name' => "Disnep",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendPatch("/categories/3", [
            'name' => "Disney"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Disney"
        ]);
    }

    public function tryToDeleteCategory(ApiTester $I): void
    {
        $I->haveInDatabase('categories', [
            'id' => 3,
            'name' => "Disnep",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendDelete("/categories/3");
        $I->seeResponseCodeIs(204);
    }
}
