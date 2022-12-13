<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Atom;

use App\Infrastructure\Queue\Amqp\ChannelInterface;
use Mockery;

trait AssertEventTrait
{
    public function assertEvent(array $argumentsSet = []): void
    {
        $channel = Mockery::mock(ChannelInterface::class);

        $channel
            ->shouldReceive('isOpen')
            ->andReturn(true);

        if (0 === count($argumentsSet)) {
            $channel->shouldNotReceive('publish');
        } else {
            foreach ($argumentsSet as $set) {
                $channel
                    ->shouldReceive('publish')
                    ->with($set[1], $set[0]);
            }
        }

        self::getContainer()->set(ChannelInterface::class, $channel);
    }
}
