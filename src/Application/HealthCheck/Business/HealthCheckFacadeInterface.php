<?php

namespace App\Application\HealthCheck\Business;

interface HealthCheckFacadeInterface
{
    public function check(): array;
}
