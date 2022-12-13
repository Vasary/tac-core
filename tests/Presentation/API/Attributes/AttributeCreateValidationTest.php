<?php

declare(strict_types=1);

namespace App\Tests\Presentation\API\Attributes;

use App\Domain\Model\Attribute;
use App\Infrastructure\Test\AbstractWebTestCase;
use App\Infrastructure\Test\Atom\AssertAttributeTrait;
use App\Infrastructure\Test\Atom\AssertEventTrait;
use App\Infrastructure\Test\Atom\AssertValidationResponseTrait;
use App\Infrastructure\Test\Context\Model\UserContext;

final class AttributeCreateValidationTest extends AbstractWebTestCase
{
    use AssertAttributeTrait, AssertValidationResponseTrait, AssertEventTrait;

    public function testShouldFailByCodeValidation(): void
    {
        $this->assertEvent();
        $this->withUser((new UserContext())());

        $this->browser->jsonRequest('POST', '/api/attributes', [
            'code' => $this->faker->regexify('/[a-z]{26}'),
            'name' => $this->faker->name(),
            'description' => $this->faker->realText(255),
            'type' => 'string',
        ]);

        $this->assertValidationError(
            $this->browser->getResponse(),
            400,
            'code',
            'Attribute code should be mre then 3 and less then 25 symbols'
        );

        $this->assertDatabaseCount(Attribute::class, 0, [
            'code' => 'name',
        ]);
    }

    public function testShouldFailByNameValidation(): void
    {
        $this->assertEvent();
        $this->withUser((new UserContext())());

        $this->browser->jsonRequest('POST', '/api/attributes', [
            'code' => 'name',
            'name' => $this->faker->regexify('/[a-zA-Z\s]{51}'),
            'description' => $this->faker->realText(255),
            'type' => 'string',
        ]);

        $this->assertValidationError(
            $this->browser->getResponse(),
            400,
            'name',
            'Attribute name should be mre then 3 and less then 50 symbols'
        );

        $this->assertDatabaseCount(Attribute::class, 0, [
            'code' => 'name',
        ]);
    }

    public function testShouldFailByDescriptionValidation(): void
    {
        $this->assertEvent();
        $this->withUser((new UserContext())());

        $this->browser->jsonRequest('POST', '/api/attributes', [
            'code' => 'name',
            'name' => $this->faker->name(),
            'description' => $this->faker->regexify('/[a-z]{256}'),
            'type' => 'string',
        ]);

        $this->assertValidationError(
            $this->browser->getResponse(),
            400,
            'description',
            'Attribute description should be mre then 3 and less then 255 symbols'
        );

        $this->assertDatabaseCount(Attribute::class, 0, [
            'code' => 'name',
        ]);
    }

    public function testShouldFailByTypeValidation(): void
    {
        $this->assertEvent();
        $this->withUser((new UserContext())());

        $this->browser->jsonRequest('POST', '/api/attributes', [
            'code' => 'name',
            'name' => $this->faker->name(),
            'description' => $this->faker->realText(255),
            'type' => 'invalid-type',
        ]);

        $this->assertValidationError(
            $this->browser->getResponse(),
            400,
            'type',
            'Attribute type has to be one of the allowed types'
        );

        $this->assertDatabaseCount(Attribute::class, 0, [
            'code' => 'name',
        ]);
    }
}
