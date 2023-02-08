<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Stub;

use App\Application\Shared\Contract\TransactionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class TransactionalServiceStub implements TransactionServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function start(): void
    {
    }

    public function commit(): void
    {
        $this->entityManager->flush();
    }

    public function rollback(): void
    {
        $this->entityManager->clear();
    }
}
