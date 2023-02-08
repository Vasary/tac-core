<?php

declare(strict_types = 1);

namespace App\Application\Unit\Business\Updater;

use App\Domain\Model\Unit;
use App\Domain\Repository\UnitRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Suggestion;
use App\Domain\ValueObject\Suggestions;
use App\Shared\Exception\UnitNotFound;
use App\Shared\Transfer\DeleteUnitTransfer;
use App\Shared\Transfer\UpdateUnitTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class Updater implements UpdaterInterface
{
    public function __construct(
        private readonly UnitRepositoryInterface $repository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function delete(DeleteUnitTransfer $transfer): void
    {
        $unit = $this->repository->findById(Id::fromString($transfer->getId()));
        if (null === $unit) {
            throw new UnitNotFound();
        }

        $this->repository->delete($unit);
    }

    public function update(UpdateUnitTransfer $transfer): Unit
    {
        $unit = $this->repository->findById(Id::fromString($transfer->getId()));
        if (null === $unit) {
            throw new UnitNotFound();
        }

        $name = new I18N($transfer->getName());
        $alias = new I18N($transfer->getAlias());

        $suggestions = new Suggestions();
        foreach ($transfer->getSuggestions() as $suggestion) {
            $suggestions->addSuggestions(new Suggestion($suggestion));
        }

        $unit->setName($name);
        $unit->setAlias($alias);
        $unit->setSuggestions($suggestions);

        $this->entityManager->persist($unit);

        return $unit;
    }
}
