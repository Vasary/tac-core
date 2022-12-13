<?php

declare(strict_types=1);

namespace App\Tests\Application\DomainEvent\Persistence;

use App\Application\DomainEvent\Persistence\EventStore;
use App\Domain\Event\EventInterface;
use App\Infrastructure\Test\AbstractUnitTestCase;

final class EventStoreTest extends AbstractUnitTestCase
{
    public function testShouldSuccessfullyCheckDomainEventsCollector(): void
    {
        $eventStore = new EventStore();

        $this->assertTrue($eventStore->isEmpty());

        $class = new class() implements EventInterface {};

        $eventStore->add($class);
        $eventStore->add($class);

        $this->assertFalse($eventStore->isEmpty());
        $this->assertInstanceOf(EventInterface::class, $eventStore->dequeue()->current());
        $this->assertTrue($eventStore->isEmpty());
    }
}
