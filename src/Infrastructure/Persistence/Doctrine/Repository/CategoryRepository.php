<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Category;
use App\Domain\Model\User;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Generator;

final class CategoryRepository implements CategoryRepositoryInterface
{
    private ObjectRepository $objectRepository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $entityManager->getRepository(Category::class);
    }

    public function create(I18N $name, User $user): Category
    {
        return new Category($name, $user);
    }

    public function list(int $page, int $size): Generator
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($size)
            ->setFirstResult($size * ($page - 1))
            ->getQuery()
            ->toIterable();
    }

    public function findById(Id $id): ?Category
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter('id', (string)$id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function totalCount(): int
    {
        return $this->objectRepository
            ->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function delete(Category $category): void
    {
        $this->entityManager->remove($category);
    }
}
