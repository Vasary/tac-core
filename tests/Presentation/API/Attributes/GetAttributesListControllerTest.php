<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Attributes;

use App\Infrastructure\Json\Json;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Context\Model\UserContext;

final class GetAttributesListControllerTest extends AbstractWebTestCase
{
    use AssertEventTrait;

    public function testShouldSuccessfullyRetrieveAttributesList(): void
    {
        $this->expectEvents();

        $user = (new UserContext())();

        $this->load(
            $this->faker->attribute(),
            $this->faker->attribute(),
            $this->faker->attribute(),
            $user,
        );


        $this->withUser($user);

        $response = $this->sendRequest('GET', '/api/attributes?page=1&size=2');

        $responseContent = (string) $response->getContent();

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($responseContent);

        $decodedContent = Json::decode($responseContent);

        $this->assertCount(2, $decodedContent);
    }
}
