<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Transactional;

use App\Application\Shared\Contract\TransactionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTransactionService implements TransactionServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function start(): void
    {
        $this->entityManager->getConnection()->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->flush();
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->getConnection()->commit();
        }
    }

    public function rollback(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->getConnection()->rollBack();
        }

        $this->entityManager->clear();
    }
}
