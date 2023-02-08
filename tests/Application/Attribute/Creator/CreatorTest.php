<?php

declare(strict_types = 1);

namespace App\Tests\Application\Attribute\Creator;

use App\Application\AttributeValue\Business\Creator\AttributeValueCreator;
use App\Application\AttributeValue\Business\Creator\TypeCreator\BooleanCreator;
use App\Application\AttributeValue\Business\Creator\TypeCreator\FloatCreator;
use App\Application\AttributeValue\Business\Creator\TypeCreator\IntegerCreator;
use App\Application\AttributeValue\Business\Creator\TypeCreator\StringCreator;
use App\Application\AttributeValue\Business\Creator\TypeCreator\TypeResolver;
use App\Application\AttributeValue\Dependency\AttributeValueToAttributeFacadeBridgeInterface;
use App\Domain\Model\Attribute\Type\AbstractType;
use App\Domain\Model\Attribute\Type\BooleanType;
use App\Domain\Model\Attribute\Type\FloatType;
use App\Domain\Model\Attribute\Type\IntegerType;
use App\Domain\Model\Attribute\Type\StringType;
use App\Domain\Model\AttributeValue;
use App\Domain\Repository\AttributeValueRepositoryInterface;
use App\Infrastructure\Security\Security;
use App\Infrastructure\Test\AbstractUnitTestCase;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Infrastructure\Test\Context\Model\UserContext;
use App\Shared\Exception\AttributeNotFound;
use App\Shared\Transfer\AttributeValueTransfer;
use Mockery;

final class CreatorTest extends AbstractUnitTestCase
{
    public function testShouldThrowExceptionByAttributeIsNotExistsReason(): void
    {
        $this->expectException(AttributeNotFound::class);

        $typeResolver = Mockery::mock(TypeResolver::class);
        $security = Mockery::mock(Security::class);

        $bridge = Mockery::mock(AttributeValueToAttributeFacadeBridgeInterface::class);
        $bridge
            ->shouldReceive('getById')->andThrow(AttributeNotFound::class);
        ;

        $attributeCreator = new AttributeValueCreator($typeResolver, $security, $bridge);

        $attributeTransfer = AttributeValueTransfer::fromArray([
            'id' => $this->faker->uuidv4(),
            'value' => 'John',
        ]);

        $attributeCreator->create($attributeTransfer)->current();
    }

    public function attributeTypesDataProvider(): array
    {
        return
        [
            [
                new FloatType(),
                '1.00',
                FloatCreator::class,
            ],
            [
                new IntegerType(),
                '2',
                IntegerCreator::class,
            ],
            [
                new BooleanType(),
                'true',
                BooleanCreator::class,
            ],
            [
                new StringType(),
                'John',
                StringCreator::class,
            ],
        ];
    }

    /**
     * @dataProvider attributeTypesDataProvider
     */
    public function testShouldSuccessfullyRetrieveAttributeList(AbstractType $type, mixed $expectedValue, string $creator): void
    {
        $attributeContext = AttributeContext::create();
        $attributeContext->type = $type;

        $attribute = $attributeContext();
        $user = UserContext::create()();

        $attributeValue = new AttributeValue(
            $attribute,
            new AttributeValue\Value($expectedValue),
            $user,
            null
        );

        $attributeValueRepository = Mockery::mock(AttributeValueRepositoryInterface::class);
        $attributeValueRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($attributeValue)
        ;

        $typeResolver = Mockery::mock(TypeResolver::class);
        $typeResolver
            ->shouldReceive('resolve')
            ->once()
            ->andReturn(new $creator($attributeValueRepository))
        ;

        $security = Mockery::mock(Security::class);
        $security
            ->shouldReceive('getDomainUser')
            ->once()
            ->andReturn($user)
        ;

        $bridge = Mockery::mock(AttributeValueToAttributeFacadeBridgeInterface::class);
        $bridge
            ->shouldReceive('getById')->andReturn($attribute)
        ;

        $attributeCreator = new AttributeValueCreator($typeResolver, $security, $bridge);

        $attributeTransfer = AttributeValueTransfer::fromArray([
            'id' => '888c23c6-06fe-4a95-a66c-f292da2f7607',
            'value' => $expectedValue,
        ]);

        $list = $attributeCreator->create($attributeTransfer);

        $attributeValue = $list->current();

        $this->assertInstanceOf(AttributeValue::class, $attributeValue);
        $this->assertEquals($expectedValue, $attributeValue->getValue()->getValue());
        $this->assertEquals('name', $attributeValue->getAttribute()->getCode());
        $this->assertEquals((string)$type, (string)$attributeValue->getAttribute()->getType());
        $this->assertNull($attributeValue->getParent());

        $list->next();
        $this->assertNull($list->current());
    }
}
