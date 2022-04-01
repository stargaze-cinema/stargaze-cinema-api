<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Producer;
use App\Tests\ApiTester;

class MoviesCest
{
    public function tryToGetMovie(ApiTester $I): void
    {
        $I->haveInRepository(Movie::class, [
            'category' => $I->grabEntityFromRepository(Category::class, ['id' => 1]),
            'producer' => $I->grabEntityFromRepository(Producer::class, ['id' => 1]),
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 120,
        ]);

        $I->sendGet('/movies');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            [
                'title' => 'Raya And The Last Dragon'
            ]
        ]);
    }

    public function tryToGetInvalidMovie(ApiTester $I): void
    {
        $I->sendGet('/movies/420');
        $I->seeResponseCodeIsClientError();
    }

    public function tryToPostMovie(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/movies', [
            'category_id' => 3,
            'producer_id' => 3,
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 120
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidMovie(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/movies', [
            'category_id' => "Cartoon",
            'producer_id' => "Somebody",
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2021,
            'duration' => 'long'
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseIsJson();
    }

    public function tryToPatchMovie(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Movie::class, [
            'category' => $I->grabEntityFromRepository(Category::class, ['id' => 1]),
            'producer' => $I->grabEntityFromRepository(Producer::class, ['id' => 1]),
            'title' => "Raya And The Last Dragon",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2019,
            'duration' => 120,
        ]);
        $id = $I->grabFromRepository(Movie::class, 'id', ['title' => 'Raya And The Last Dragon']);
        $I->sendPatch("/movies/$id", [
            'description' => "Updated text.",
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryToDeleteMovie(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Movie::class, [
            'category' => $I->grabEntityFromRepository(Category::class, ['id' => 1]),
            'producer' => $I->grabEntityFromRepository(Producer::class, ['id' => 1]),
            'title' => "Delete me",
            'description' => "Some text.",
            'price' => 10.00,
            'year' => 2019,
            'duration' => 120,
        ]);
        $id = $I->grabFromRepository(Movie::class, 'id', ['title' => 'Delete me']);
        $I->sendDelete("/movies/$id");
        $I->seeResponseCodeIsSuccessful();
    }
}
