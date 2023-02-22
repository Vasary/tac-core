<?php

declare(strict_types = 1);

namespace App\Application\HealthCheck\Communication\Plugins;

use App\Application\HealthCheck\Business\Checker\HealthCheckerPluginInterface;
use App\Application\HealthCheck\Business\Checker\Response;
use PhpAmqpLib\Connection\AbstractConnection;

final class RabbitMQConnectionCheckerPlugin implements HealthCheckerPluginInterface
{
    private const CHECK_RESULT_NAME = 'amqp';

    public function __construct(private readonly AbstractConnection $channel)
    {
    }

    public function check(): Response
    {
        $this->channel->channel();

        return new Response(self::CHECK_RESULT_NAME, $this->channel->isConnected(), 'ok');
    }
}
