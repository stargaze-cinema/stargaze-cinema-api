<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Country;
use App\Tests\ApiTester;

class CountriesCest
{
    public function tryToGetCountry(ApiTester $I): void
    {
        $I->haveInRepository(Country::class, [
            'name' => 'Niger',
        ]);

        $I->sendGet('/countries');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            [
                'name' => 'Niger'
            ]
        ]);
    }

    public function tryToGetInvalidCountry(ApiTester $I): void
    {
        $I->sendGet('/countries/420');
        $I->seeResponseCodeIsClientError();
    }

    public function tryToPostCountry(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/countries', [
            'name' => 'Niger',
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidCountry(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/countries', [
            'name' => 422,
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseIsJson();
    }

    public function tryToPatchCountry(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Country::class, [
            'name' => "Niger"
        ]);
        $id = $I->grabFromRepository(Country::class, 'id', ['name' => 'Niger']);
        $I->sendPatch("/countries/$id", [
            'name' => "Nigeria"
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            'name' => "Nigeria"
        ]);
    }

    public function tryToDeleteCountry(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Country::class, [
            'name' => "Delete me"
        ]);
        $id = $I->grabFromRepository(Country::class, 'id', ['name' => 'Delete me']);
        $I->sendDelete("/countries/$id");
        $I->seeResponseCodeIsSuccessful();
    }
}
