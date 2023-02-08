<?php

declare(strict_types = 1);

namespace App\Presentation\ExceptionListener\ExceptionHandler;

use App\Infrastructure\Response\JsonResponse;
use App\Presentation\ExceptionListener\ExceptionHandler\Handler\AbstractHandler;
use RuntimeException;
use Throwable;

final class ChainRunner
{
    public function __construct(private readonly array $handlers = [])
    {
    }

    public function run(Throwable $throwable): JsonResponse
    {
        foreach ($this->handlers as $handler) {
            /* @var $handler AbstractHandler */
            try {
                return $handler->handle($throwable);
            } catch (RuntimeException) {
            }
        }

        throw new RuntimeException($throwable->getMessage());
    }
}
