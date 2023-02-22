<?php

namespace App\Application\HealthCheck\Business\Checker;

interface HealthCheckerPluginInterface
{
    public function check(): Response;
}
