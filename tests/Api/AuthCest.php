<?php

declare(strict_types=1);

namespace App\Tests\Api;

use \App\Tests\ApiTester;

class AuthCest
{
    public function tryToSignUpInvalidEmail(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/auth/signup', [
            'name' => "FluffyTester",
            'email' => "fluffytester@io",
            'password' => "securepass",
            'password_confirmation' => "securepass"
        ]);
        $I->seeResponseCodeIs(409);
    }

    public function tryToSignUpInvalidPassword(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/auth/signup', [
            'name' => "FluffyTester",
            'email' => "fluffytester@test.net",
            'password' => "securepass",
            'password_confirmation' => "unsecurepass"
        ]);
        $I->seeResponseCodeIs(409);
    }

    public function tryToSignUp(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/auth/signup', [
            'name' => "FluffyTester",
            'email' => "fluffytester@test.net",
            'password' => "securepass",
            'password_confirmation' => "securepass"
        ]);
        $I->seeResponseCodeIs(201);
    }

    public function tryToSignIn(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/auth/signin', [
            'email' => "fluffytester@test.net",
            'password' => "securepass",
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
