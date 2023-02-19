<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Category;
use App\Domain\Model\Product;
use App\Domain\Model\User;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Generator;

final class ProductRepository implements ProductRepositoryInterface
{
    private ObjectRepository $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $entityManager->getRepository(Product::class);
    }

    public function findById(Id $id): ?Product
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', (string) $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function create(I18N $name, I18N $description, User $creator, Category $category,): Product {
        return new Product($name, $description, $creator, $category);
    }

    public function list(int $page, int $size): Generator
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($size)
            ->setFirstResult($size * ($page - 1))
            ->getQuery()
            ->toIterable();
    }

    public function totalCount(): int
    {
        return $this->objectRepository
            ->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function delete(Product $product): void
    {
        $this->entityManager->remove($product);
    }
}
