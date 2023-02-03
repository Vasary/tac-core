<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Context;

interface ModelContextInterface
{
    public function __invoke(bool $theOnlyOne = true): object;

    public static function create(): static;

    public static function clean(): void;
}
