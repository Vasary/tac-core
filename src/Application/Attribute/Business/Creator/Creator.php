<?php

declare(strict_types=1);

namespace App\Application\Attribute\Business\Creator;

use App\Application\Security\SecurityInterface;
use App\Domain\Factory\TypeFactory;
use App\Domain\Model\Attribute;
use App\Domain\Repository\AttributeRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Shared\Transfer\AttributeCreateTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class Creator implements CreatorInterface
{
    public function __construct(
        private readonly SecurityInterface            $security,
        private readonly AttributeRepositoryInterface $attributeRepository,
        private readonly EntityManagerInterface       $entityManager,
    )
    {
    }

    public function create(AttributeCreateTransfer $transfer): Attribute
    {
        $user = $this->security->getDomainUser();

        $name = new I18N($transfer->getName());
        $description = new I18N($transfer->getDescription());

        $attribute = $this->attributeRepository
            ->create(
                $transfer->getCode(),
                $name,
                $description,
                TypeFactory::create($transfer->getType()),
                $user
            );

        $this->entityManager->persist($attribute);

        return $attribute;
    }
}
