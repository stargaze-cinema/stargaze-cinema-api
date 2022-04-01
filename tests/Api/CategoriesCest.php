<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Category;
use App\Tests\ApiTester;

class CategoriesCest
{
    public function tryToGetCategory(ApiTester $I): void
    {
        $I->haveInRepository(Category::class, [
            'name' => "Action",
        ]);

        $I->sendGet('/categories');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            [
                'name' => 'Action'
            ]
        ]);
    }

    public function tryToGetInvalidCategory(ApiTester $I): void
    {
        $I->sendGet('/categories/420');
        $I->seeResponseCodeIsClientError();
    }

    public function tryToPostCategory(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/categories', [
            'name' => 'Cringe'
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidCategory(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/categories', [
            'name' => true
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseIsJson();
    }

    public function tryToPatchCategory(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Category::class, [
            'name' => "Disnep"
        ]);
        $id = $I->grabFromRepository(Category::class, 'id', ['name' => 'Disnep']);
        $I->sendPatch("/categories/$id", [
            'name' => "Disney"
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            'name' => "Disney"
        ]);
    }

    public function tryToDeleteCategory(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Category::class, [
            'name' => "Delete me"
        ]);
        $id = $I->grabFromRepository(Category::class, 'id', ['name' => 'Delete me']);
        $I->sendDelete("/categories/$id");
        $I->seeResponseCodeIsSuccessful();
    }
}
