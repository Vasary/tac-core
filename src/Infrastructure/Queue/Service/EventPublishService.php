<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Service;

use App\Application\Shared\Contract\EventPublisherInterface;
use App\Infrastructure\Queue\Amqp\ChannelInterface;
use App\Infrastructure\Queue\Exception\QueueException;
use App\Infrastructure\Queue\Message\Message;
use PhpAmqpLib\Exception\AMQPExceptionInterface;

final class EventPublishService implements EventPublisherInterface
{
    public function __construct(
        private readonly ChannelInterface $channel,
    ) {
    }

    public function publish(Message $message): void
    {
        if (!$this->channel->isOpen()) {
            throw new QueueException('Channel is closed', 0);
        }

        try {
            $this->channel->publish($message->getEvent(), $message->getDestinationStamp());
        } catch (AMQPExceptionInterface $exception) {
            throw new QueueException('Queue exception', 0, $exception);
        }
    }
}
