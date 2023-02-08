<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Attributes;

use App\Domain\Model\Attribute;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Atom\AssertValidationResponseTrait;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\UserContext;

final class AttributeDuplicationTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertValidationResponseTrait, AssertEventTrait;

    protected static array $ids = [
        '1c3ccf66-dfc9-49e5-92df-0df86ec46e74',
        'be016bd9-5940-457a-9971-2f9988c6424e',
        'b0cc64a9-0acf-4c37-8c09-da78715090eb',
    ];

    public function testShouldFailByDuplicateAttributeError(): void
    {
        $this->assertEvent();

        $this->withUser((new UserContext())());
        $this->load((new AttributeContext())());

        $this->browser->jsonRequest('POST', '/api/attributes', [
            'code' => 'name',
            'name' => $this->faker->name(),
            'description' => $this->faker->realText(255),
            'type' => 'string',
        ]);

        $responseContent = (string)$this->browser->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(409);
        $this->assertJson($responseContent);
        $this->assertDatabaseCount(Attribute::class, 1, [
            'code' => 'name',
        ]);
    }
}
