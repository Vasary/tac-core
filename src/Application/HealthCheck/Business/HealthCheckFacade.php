<?php

declare(strict_types=1);

namespace App\Application\HealthCheck\Business;

use App\Application\HealthCheck\Business\Checker\Checker;

readonly class HealthCheckFacade implements HealthCheckFacadeInterface
{
    public function __construct(
        private Checker $checker
    )
    {
    }

    public function check(): array
    {
        return $this->checker->check();
    }
}
