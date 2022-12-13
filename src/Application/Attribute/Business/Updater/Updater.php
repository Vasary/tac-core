<?php

declare(strict_types=1);

namespace App\Application\Attribute\Business\Updater;

use App\Domain\Factory\TypeFactory;
use App\Domain\Model\Attribute;
use App\Domain\Repository\AttributeRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Shared\Exception\AttributeNotFound;
use App\Shared\Transfer\DeleteAttributeTransfer;
use App\Shared\Transfer\UpdateAttributeTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class Updater implements UpdaterInterface
{
    public function __construct(
        private readonly AttributeRepositoryInterface $attributeRepository,
        private readonly EntityManagerInterface       $entityManager
    )
    {
    }

    public function update(UpdateAttributeTransfer $transfer): Attribute
    {
        $attribute = $this->attributeRepository->findById(Id::fromString($transfer->getId()));
        if (null === $attribute) {
            throw new AttributeNotFound();
        }

        $attribute
            ->setName(new I18N($transfer->getName()))
            ->setDescription(new I18N($transfer->getDescription()))
            ->setCode($transfer->getCode())
            ->setType(TypeFactory::create($transfer->getType()));

        $this->entityManager->persist($attribute);

        return $attribute;
    }

    public function delete(DeleteAttributeTransfer $transfer): void
    {
        $attribute = $this->attributeRepository->findById(Id::fromString($transfer->getId()));
        if (null === $attribute) {
            throw new AttributeNotFound();
        }

        $this->attributeRepository->delete($attribute);
    }
}
