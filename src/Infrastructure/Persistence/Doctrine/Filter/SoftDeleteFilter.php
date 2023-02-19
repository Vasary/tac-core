<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Filter;

use Closure;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

final class SoftDeleteFilter extends SQLFilter
{
    private const COLUMN_NAME = 'deletedAt';

    protected ?EntityManagerInterface $entityManager = null;

    /**
     * @throws Exception
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, mixed $targetTableAlias): string
    {
        if (!$targetEntity->hasField(self::COLUMN_NAME)) {
            return '';
        }

        $platform = $this->getConnection()->getDatabasePlatform();
        $quoteStrategy = $this->getEntityManager()->getConfiguration()->getQuoteStrategy();

        $column = $quoteStrategy->getColumnName(self::COLUMN_NAME, $targetEntity, $platform);

        return $column.' IS NULL';
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        if (null === $this->entityManager) {
            $getEntityManager = Closure::bind(fn (): EntityManagerInterface => $this->em, $this, parent::class);

            $this->entityManager = $getEntityManager();
        }

        return $this->entityManager;
    }
}
