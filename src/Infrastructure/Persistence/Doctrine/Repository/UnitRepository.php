<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Unit;
use App\Domain\Model\User;
use App\Domain\Repository\UnitRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Suggestions;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Generator;

final class UnitRepository implements UnitRepositoryInterface
{
    private ObjectRepository $objectRepository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $entityManager->getRepository(Unit::class);
    }

    public function create(I18N $name, I18N $alias, Suggestions $suggestions, User $user): Unit
    {
        return new Unit($name, $alias, $suggestions, $user);
    }

    public function list(int $page, int $size): Generator
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'DESC')
            ->setMaxResults($size)
            ->setFirstResult($size * ($page - 1))
            ->getQuery()
            ->toIterable();
    }

    public function findById(Id $id): ?Unit
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->setParameter('id', (string)$id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function totalCount(): int
    {
        return $this->objectRepository
            ->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function delete(Unit $category): void
    {
        $this->entityManager->remove($category);
    }
}
