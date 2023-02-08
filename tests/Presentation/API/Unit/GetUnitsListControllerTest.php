<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Unit;

use App\Domain\Model\Unit;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetUnitsListControllerTest extends AbstractWebTestCase
{
    public function testShouldSuccessfullyRetrieveUnitsList(): void
    {
        $user = UserContext::create()();

        $this->load($user, $this->faker->unit(), $this->faker->unit());
        $this->withUser($user);

        $this->browser->request('GET', '/api/units?page=1&size=1');

        $responseContent = (string)$this->browser->getResponse()->getContent();

        self::assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = json_decode($responseContent, true);

        $this->assertArrayHasKey('items', $decodedContent);
        $this->assertArrayHasKey('total', $decodedContent);

        $this->assertEquals(2, $decodedContent['total']);
        $this->assertDatabaseCount(Unit::class, 2);
        $this->assertCount(1, $decodedContent['items']);
    }
}
