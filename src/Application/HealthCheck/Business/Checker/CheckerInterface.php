<?php

namespace App\Application\HealthCheck\Business\Checker;

interface CheckerInterface
{
    public function check(): array;
}
