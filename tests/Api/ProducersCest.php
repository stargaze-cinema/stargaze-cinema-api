<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Producer;
use App\Tests\ApiTester;

class ProducersCest
{
    public function tryToGetProducer(ApiTester $I): void
    {
        $I->haveInRepository(Producer::class, [
            'name' => "Ryan Raynolds",
        ]);

        $I->sendGet('/producers');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            [
                'name' => 'Ryan Raynolds'
            ]
        ]);
    }

    public function tryToGetInvalidProducer(ApiTester $I): void
    {
        $I->sendGet('/producers/420');
        $I->seeResponseCodeIsClientError();
    }

    public function tryToPostProducer(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/producers', [
            'name' => "Ryan Raynolds",
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryToPostInvalidProducer(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->sendPost('/producers', [
            'name' => 422,
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseIsJson();
    }

    public function tryToPatchProducer(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Producer::class, [
            'name' => "Ryan Raynolds"
        ]);
        $id = $I->grabFromRepository(Producer::class, 'id', ['name' => 'Ryan Raynolds']);
        $I->sendPatch("/producers/$id", [
            'name' => "Star Raynolds"
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson([
            'name' => "Star Raynolds"
        ]);
    }

    public function tryToDeleteProducer(ApiTester $I): void
    {
        $I->amBearerAuthorized();
        $I->haveInRepository(Producer::class, [
            'name' => "Ryan Raynolds"
        ]);
        $id = $I->grabFromRepository(Producer::class, 'id', ['name' => 'Ryan Raynolds']);
        $I->sendDelete("/producers/$id");
        $I->seeResponseCodeIsSuccessful();
    }
}
