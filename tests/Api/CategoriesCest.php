<?php

namespace App\Tests\Api;

use \App\Tests\ApiTester;

class CategoriesCest
{
    public function tryToGetCategory(ApiTester $I)
    {
        $I->haveInDatabase('categories', [
            'id' => 1,
            'name' => "Action",
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

    public function tryToPostPatchDeleteCategory(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/categories', [
            'name' => 'Action'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPatch("/categories/" . $response->id, [
            'name' => "Cartoon"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => "Cartoon"
        ]);

        $I->deleteHeader('Content-Type');
        $I->sendDelete("/categories/" . $response->id);
        $I->seeResponseCodeIs(204);
    }
}
