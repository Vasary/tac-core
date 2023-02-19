<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Attribute;
use App\Domain\Model\Attribute\Type\AbstractType;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\User;
use App\Domain\Repository\AttributeRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Generator;

final class AttributeRepository implements AttributeRepositoryInterface
{
    private ObjectRepository $objectRepository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $entityManager->getRepository(Attribute::class);
    }

    public function create(
        string $code,
        I18N $name,
        I18N $description,
        AbstractType $type,
        User $creator
    ): Attribute {
        return new Attribute(
            $code,
            $name,
            $description,
            $type,
            $creator
        );
    }

    public function findByCode(AttributeValue\Code $code): ?Attribute
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('a')
            ->where('a.code = :code')
            ->setParameter('code', (string)$code)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function list(int $page, int $size): Generator
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($size)
            ->setFirstResult($size * ($page - 1))
            ->getQuery()
            ->toIterable();
    }

    public function findById(Id $id): ?Attribute
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('a')
            ->where('a.id = :id')
            ->setParameter('id', (string)$id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function totalCount(): int
    {
        return $this->objectRepository
            ->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function delete(Attribute $attribute): void
    {
        $this->entityManager->remove($attribute);
    }
}
