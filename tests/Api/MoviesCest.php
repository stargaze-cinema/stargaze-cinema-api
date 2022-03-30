<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\ApiTester;

class MoviesCest
{
    public function tryToGetMovie(ApiTester $I): void
    {
        $I->haveInDatabase('categories', [
            'id' => 3,
            'name' => "Disney",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->haveInDatabase('producers', [
            'id' => 3,
            'name' => "Somedude",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->haveInDatabase('movies', [
            'id' => 3,
            'category_id' => 3,
            'producer_id' => 3,
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 120,
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);

        $I->sendGet('/movies');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'title' => 'Raya And The Last Dragon'
            ]
        ]);
    }

    public function tryToGetInvalidMovie(ApiTester $I): void
    {
        $I->sendGet('/movies/420');
        $I->seeResponseCodeIs(404);
    }

    public function tryToPostMovie(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/movies', [
            'category' => "Cartoon",
            'producer' => "Somebody",
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 120
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidMovie(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/movies', [
            'category' => "Cartoon",
            'producer' => "Somebody",
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 'long'
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
    }

    public function tryToPatchMovie(ApiTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveInDatabase('categories', [
            'id' => 3,
            'name' => "Disney",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->haveInDatabase('producers', [
            'id' => 3,
            'name' => "Somedude",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->haveInDatabase('movies', [
            'id' => 3,
            'category_id' => 3,
            'producer_id' => 3,
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2019,
            'duration' => 120,
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendPatch('/movies/3', [
            'description' => "Updated text.",
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function tryToDeleteMovie(ApiTester $I): void
    {
        $I->haveInDatabase('categories', [
            'id' => 3,
            'name' => "Disney",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->haveInDatabase('producers', [
            'id' => 3,
            'name' => "Somedude",
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->haveInDatabase('movies', [
            'id' => 3,
            'category_id' => 3,
            'producer_id' => 3,
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2019,
            'duration' => 120,
            'created_at' => date("Y-m-d", time()),
            'updated_at' => date("Y-m-d", time())
        ]);
        $I->sendDelete("/movies/3");
        $I->seeResponseCodeIs(204);
    }
}
