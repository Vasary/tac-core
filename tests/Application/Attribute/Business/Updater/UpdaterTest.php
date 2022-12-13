<?php

namespace App\Tests\Application\Attribute\Business\Updater;

use App\Application\Attribute\Business\Updater\Updater;
use App\Domain\Model\Attribute;
use App\Domain\Repository\AttributeRepositoryInterface;
use App\Infrastructure\Test\AbstractUnitTestCase;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use App\Shared\Exception\AttributeNotFound;
use App\Shared\Transfer\UpdateAttributeTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;

final class UpdaterTest extends AbstractUnitTestCase
{
    public function testShouldCatchAttributeNotFoundException(): void
    {
        $transfer = UpdateAttributeTransfer::fromArray(
            [
                'id' => $this->faker->uuidv4(),
                'name' => 'John',
                'description' => 'Doe',
                'code' => 'code',
                'type' => 'integer'
            ]
        );

        $repository = Mockery::mock(AttributeRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->andReturn(null);

        $entityManagerMock = Mockery::mock(EntityManagerInterface::class);

        $updater = new Updater($repository, $entityManagerMock);

        $this->expectException(AttributeNotFound::class);
        $this->expectExceptionMessage('Attribute not found');

        $updater->update($transfer);
    }

    public function testShouldReturnSuccessfullyUpdatedAttribute(): void
    {
        $transfer = UpdateAttributeTransfer::fromArray(
            [
                'id' => $this->faker->uuidv4(),
                'name' => 'New name',
                'description' => 'New description',
                'code' => 'new_code',
                'type' => 'boolean'
            ]
        );

        $attribute = AttributeContext::create()();

        $repository = Mockery::mock(AttributeRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->andReturn($attribute);

        $entityManagerMock = Mockery::mock(EntityManagerInterface::class);
        $entityManagerMock
            ->shouldReceive('persist')
            ->once()
        ;

        $updater = new Updater($repository, $entityManagerMock);

        $result = $updater->update($transfer);

        $this->assertInstanceOf(Attribute::class, $result);
        $this->assertEquals('New name', (string)$result->getName());
        $this->assertEquals('New description', (string)$result->getDescription());
        $this->assertEquals('new_code', $result->getCode());
        $this->assertEquals('boolean', (string)$result->getType());
    }
}
