<?php

declare(strict_types = 1);

namespace App\Application\Category\Business\Creator;

use App\Application\Security\SecurityInterface;
use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Shared\Transfer\CategoryCreateTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class Creator implements CreatorInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
        private readonly EntityManagerInterface $entityManager,
        private readonly SecurityInterface $security,
    ) {
    }

    public function create(CategoryCreateTransfer $transfer): Category
    {
        $category = $this->repository->create(new I18N($transfer->getName()), $this->security->getDomainUser());

        $this->entityManager->persist($category);

        return $category;
    }
}
