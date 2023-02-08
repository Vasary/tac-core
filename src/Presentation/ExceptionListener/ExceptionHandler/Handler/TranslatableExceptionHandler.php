<?php

declare(strict_types = 1);

namespace App\Presentation\ExceptionListener\ExceptionHandler\Handler;

use App\Application\Shared\Contract\ApplicationException;
use App\Infrastructure\HTTP\ErrorResponse;
use App\Infrastructure\Response\JsonResponse;
use Throwable;

final class TranslatableExceptionHandler extends AbstractHandler
{
    public function handle(Throwable $exception): JsonResponse
    {
        $this->couldBeHandle($exception);

        return new ErrorResponse(
            [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ],
            $exception->getCode()
        );
    }

    protected function getType(): string
    {
        return ApplicationException::class;
    }
}
