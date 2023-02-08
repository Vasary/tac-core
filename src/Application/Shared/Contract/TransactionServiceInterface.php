<?php

declare(strict_types = 1);

namespace App\Application\Shared\Contract;

interface TransactionServiceInterface
{
    public function start(): void;

    public function commit(): void;

    public function rollback(): void;
}
