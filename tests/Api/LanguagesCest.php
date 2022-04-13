<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Language;
use App\Tests\ApiTester;

class LanguagesCest
{
    public function tryToGetLanguage(ApiTester $I): void
    {
        $I->haveInRepository(Language::class, [
            'name' => 'Ukrainian',
            'code' => 'UA',
            'native_name' => 'українська',
        ]);

        $I->sendGet('/languages');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            [
                'name' => 'Ukrainian'
            ]
        ]);
    }

    public function tryToGetInvalidLanguage(ApiTester $I): void
    {
        $I->sendGet('/languages/420');
        $I->seeResponseCodeIsClientError();
    }

    public function tryToPostLanguage(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/languages', [
            'name' => 'Ukrainian',
            'code' => 'UA',
            'native_name' => 'українська',
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidLanguage(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/languages', [
            'name' => 422,
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseIsJson();
    }

    public function tryToPatchLanguage(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Language::class, [
            'name' => 'Russian',
            'code' => 'UA',
            'native_name' => 'українська',
        ]);
        $id = $I->grabFromRepository(Language::class, 'id', ['name' => 'Russian']);
        $I->sendPatch("/languages/$id", [
            'name' => "Ukrainian"
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            'name' => "Ukrainian"
        ]);
    }

    public function tryToDeleteLanguage(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Language::class, [
            'name' => "Delete me",
            'code' => 'RU',
            'native_name' => 'русский',
        ]);
        $id = $I->grabFromRepository(Language::class, 'id', ['name' => 'Delete me']);
        $I->sendDelete("/languages/$id");
        $I->seeResponseCodeIsSuccessful();
    }
}
