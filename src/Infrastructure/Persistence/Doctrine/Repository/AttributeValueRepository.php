<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\User;
use App\Domain\Repository\AttributeValueRepositoryInterface;
use App\Domain\ValueObject\Id;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Generator;

final class AttributeValueRepository implements AttributeValueRepositoryInterface
{
    private ObjectRepository $objectRepository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $entityManager->getRepository(AttributeValue::class);
    }

    public function create(
        ?Attribute $attribute,
        string $type,
        ?string $value,
        User $creator,
        ?Id $parentId
    ): AttributeValue
    {
        return new AttributeValue(
            $attribute,
            new AttributeValue\Value($value),
            $creator,
            $parentId
        );
    }

    public function findAll(int $page, int $pageSize): Generator
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('a')
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize)
            ->getQuery()
            ->toIterable();
    }

    public function get(Id $id): ?AttributeValue
    {
        return $this
            ->objectRepository
            ->createQueryBuilder('av')
            ->where('av.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByProductIdAndAttributeId(Id $productId, Id $attributeId): ?AttributeValue
    {
        $rsm = $this->objectRepository->createResultSetMappingBuilder('av');
        $select = $rsm->generateSelectClause(['av']);

        $sql = sprintf(
            'SELECT ' . $select . ' FROM attributes_values as av WHERE product_id = \'%s\' and attribute_id = \'%s\'',
            $productId,
            $attributeId
        );

        $query = $this->entityManager->createNativeQuery($sql, $rsm);

        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }

    public function getTotal(): int
    {
        return $this->objectRepository
            ->createQueryBuilder('av')
            ->select('count(av.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
