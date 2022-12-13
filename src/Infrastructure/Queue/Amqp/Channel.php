<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Amqp;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

final class Channel implements ChannelInterface
{
    public const EXCHANGE_EVENTS = 'events';
    private const HEADERS = [
        'content_type' => 'text/json',
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT,
    ];

    public function __construct(private readonly AMQPChannel $channel)
    {
    }

    public function isOpen(): bool
    {
        return $this->channel->is_open();
    }

    public function publish(string $body, string $routingKey): void
    {
        $this->channel->basic_publish(
            new AMQPMessage($body, new AMQPTable(self::HEADERS)),
            self::EXCHANGE_EVENTS,
            $routingKey
        );
    }
}
