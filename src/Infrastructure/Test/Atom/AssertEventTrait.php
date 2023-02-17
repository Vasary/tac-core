<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Atom;

use App\Infrastructure\Queue\Amqp\ChannelInterface;
use Mockery;

trait AssertEventTrait
{
    public function expectEvents(array $argumentsSet = []): void
    {
        uopz_allow_exit(true);
        $channel = $this->createChannel();

        foreach ($argumentsSet as $set) {
            $channel
                ->shouldReceive('publish')
                ->withArgs(function (string $body, string $routingKey) use ($set) {
                    [$expectedRoutingKey, $expectedBody] = $set;

                    return $expectedRoutingKey === $routingKey && $expectedBody === $body;
                })
                ->andReturnNull()
            ;
        }

        self::getContainer()->set(ChannelInterface::class, $channel);
    }

    public function expectNoEvents(): void
    {
        $channel = $this->createChannel();
        $channel->shouldNotReceive('publish');

        self::getContainer()->set(ChannelInterface::class, $channel);
    }

    private function createChannel(): ChannelInterface & Mockery\LegacyMockInterface
    {
        $channel = Mockery::mock(ChannelInterface::class);

        $channel
            ->shouldReceive('isOpen')
            ->andReturn(true);

        return $channel;
    }
}
