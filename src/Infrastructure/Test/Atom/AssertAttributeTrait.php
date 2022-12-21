<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Atom;

trait AssertAttributeTrait
{
    public function assertAttributeCodeEqual(string $code, array $attribute): void
    {
        $this->assertEquals($code, $attribute['attribute']['code']);
    }

    public function assertAttributeValueEqual(mixed $value, array $attribute): void
    {
        $this->assertEquals($value, $attribute['attribute']['value']);
    }

    public function assertAttributeTypeString(array $attribute): void
    {
        $this->assertEquals('string', $attribute['attribute']['type']);
        $this->assertIsString($attribute['attribute']['value']);
    }

    public function assertAttributeTypeInteger(array $attribute): void
    {
        $this->assertEquals('integer', $attribute['attribute']['type']);
        $this->assertIsInt($attribute['attribute']['value']);
    }

    public function assertAttributeTypeBoolean(array $attribute): void
    {
        $this->assertEquals('boolean', $attribute['attribute']['type']);
        $this->assertIsBool($attribute['attribute']['value']);
    }

    public function assertAttributeTypeFloat(array $attribute): void
    {
        $this->assertEquals('float', $attribute['attribute']['type']);
        $this->assertIsFloat($attribute['attribute']['value']);
    }

    public function assertAttributeTypeArray(array $attribute): void
    {
        $this->assertEquals('array', $attribute['attribute']['type']);
        $this->assertNull($attribute['attribute']['value']);
    }

    public function assertAttribute(array $attribute): void
    {
        $this->assertArrayHasKey('id', $attribute);
        $this->assertArrayHasKey('code', $attribute);
        $this->assertArrayHasKey('name', $attribute);
        $this->assertArrayHasKey('type', $attribute);
        $this->assertArrayHasKey('description', $attribute);
        $this->assertArrayHasKey('createdAt', $attribute);
        $this->assertArrayHasKey('updatedAt', $attribute);
        $this->assertArrayHasKey('deletedAt', $attribute);
        $this->assertArrayHasKey('creator', $attribute);
    }

    public function assertAttributeValue(array $attribute): void
    {
        $this->assertAttributeValueHasAllExpectedKeys($attribute);
    }

    public function assertAttributeValueInCollection(string $expectedCode, mixed $expectedValue, array $attributes): void
    {
        foreach ($attributes as $attribute) {
            if ($attribute['attribute']['code'] === $expectedCode && $attribute['attribute']['value'] === $expectedValue) {
                $this->assertAttributeValueHasAllExpectedKeys($attribute);
            }
        }
    }

    private function assertAttributeValueHasAllExpectedKeys(array $attribute): void
    {
        $this->assertArrayHasKey('id', $attribute);
        $this->assertIsString($attribute['id']);

        $this->assertArrayHasKey('attribute', $attribute);
        $this->assertIsArray($attribute['attribute']);

        $this->assertArrayHasKey('id', $attribute['attribute']);
        $this->assertIsString($attribute['attribute']['id']);

        $this->assertArrayHasKey('code', $attribute['attribute']);
        $this->assertIsString($attribute['attribute']['code']);

        $this->assertArrayHasKey('type', $attribute['attribute']);
        $this->assertIsString($attribute['attribute']['type']);

        $this->assertArrayHasKey('name', $attribute['attribute']);
        $this->assertIsString($attribute['attribute']['name']);

        $this->assertArrayHasKey('description', $attribute['attribute']);
        $this->assertIsString($attribute['attribute']['description']);

        $this->assertArrayHasKey('value', $attribute['attribute']);

        $this->assertArrayHasKey('creator', $attribute);
        $this->assertIsString($attribute['creator']);

        $this->assertArrayHasKey('createdAt', $attribute);
        $this->assertNotNull($attribute['createdAt']);

        $this->assertArrayHasKey('updatedAt', $attribute);
        $this->assertNotNull($attribute['updatedAt']);

        $this->assertArrayHasKey('deletedAt', $attribute);
        $this->assertNull($attribute['deletedAt']);
    }
}
