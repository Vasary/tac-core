<?php

declare(strict_types = 1);

namespace App\Tests\Application\DomainEvent\Communication;

use App\Application\DomainEvent\Communication\Observer\DomainEventsCollector;
use App\Application\DomainEvent\Persistence\EventStore;
use App\Domain\Model\User;
use App\Infrastructure\Test\AbstractUnitTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Mockery;
use stdClass;

final class DomainEventsCollectorTest extends AbstractUnitTestCase
{
    public function testShouldSuccessfullyCheckDomainEventsCollector(): void
    {
        $object = new User('mock|10101011');

        $eventStore = Mockery::mock(EventStore::class);
        $eventStore
            ->shouldReceive('add')
            ->with(...$object->popEvents())
        ;

        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $event = new LifecycleEventArgs($object, $entityManager);

        $collector = new DomainEventsCollector($eventStore);
        $collector->postPersist($event);
        $collector->postUpdate($event);
        $collector->preRemove($event);
        $collector->postRemove($event);

        $this->assertTrue(in_array('postPersist', $collector->getSubscribedEvents()));
        $this->assertTrue(in_array('postUpdate', $collector->getSubscribedEvents()));
        $this->assertTrue(in_array('preRemove', $collector->getSubscribedEvents()));
        $this->assertTrue(in_array('postRemove', $collector->getSubscribedEvents()));
    }

    public function testShouldSuccessfullyCheckDomainWithNoNewObjectHasBeenAddedIntoStorage(): void
    {
        $eventStore = Mockery::mock(EventStore::class);
        $eventStore->shouldNotHaveReceived('add');

        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $event = new LifecycleEventArgs(new stdClass(), $entityManager);

        $collector = new DomainEventsCollector($eventStore);
        $collector->postPersist($event);
        $collector->postUpdate($event);
        $collector->preRemove($event);
        $collector->postRemove($event);

        $this->assertTrue(true);
    }
}
