<?php

declare(strict_types=1);

namespace App\Tests\Application\DomainEvent\Communication;

use App\Application\DomainEvent\Communication\PublishDomainEventsSubscriber;
use App\Application\DomainEvent\Persistence\EventStore;
use App\Application\Shared\Contract\EventPublisherInterface;
use App\Infrastructure\Queue\Message\Message;
use App\Infrastructure\Test\AbstractUnitTestCase;
use Mockery;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PublishDomainEventsSubscriberTest extends AbstractUnitTestCase
{
    public function testSubscriberPosition(): void
    {
        $position = PublishDomainEventsSubscriber::getSubscribedEvents();

        $this->assertIsArray($position);
        $this->assertArrayHasKey('kernel.response', $position);
        $this->assertIsArray($position['kernel.response']);
        $this->assertCount(1, $position['kernel.response']);
        $this->assertCount(2, $position['kernel.response'][0]);
        $this->assertEquals('publishEvents', $position['kernel.response'][0][0]);
        $this->assertEquals(9, $position['kernel.response'][0][1]);
    }

    public function testPublishNoEvents(): void
    {
        $eventStore = Mockery::mock(EventStore::class);
        $eventStore->shouldNotHaveReceived('dequeue');

        $publisher = Mockery::mock(EventPublisherInterface::class);
        $publisher->shouldNotHaveReceived('publish');

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('isSuccessful')->andReturn(false);

        $event = Mockery::mock(ResponseEvent::class);
        $event->shouldReceive('getResponse')->andReturn($response);

        $subscriber = new PublishDomainEventsSubscriber($eventStore, $publisher);

        $subscriber->publishEvents($event);

        $this->assertTrue(true);
    }

    public function testPublishEvents(): void
    {
        $stdClass = new stdClass();

        $eventStore = Mockery::mock(EventStore::class);
        $eventStore->shouldReceive('dequeue')->andYield($stdClass);

        $publisher = Mockery::mock(EventPublisherInterface::class);
        $publisher->shouldReceive('publish')->once();

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('isSuccessful')->andReturn(true);

        $event = Mockery::mock(ResponseEvent::class);
        $event->shouldReceive('getResponse')->andReturn($response);

        $subscriber = new PublishDomainEventsSubscriber($eventStore, $publisher);

        $subscriber->publishEvents($event);

        $this->assertTrue(true);
    }
}
