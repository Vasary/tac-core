<?php

declare(strict_types = 1);

namespace App\Application\Unit\Business\Creator;

use App\Application\Security\SecurityInterface;
use App\Domain\Model\Unit;
use App\Domain\Repository\UnitRepositoryInterface;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Suggestion;
use App\Domain\ValueObject\Suggestions;
use App\Shared\Transfer\CreateUnitTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class Creator implements CreatorInterface
{
    public function __construct(
        private readonly SecurityInterface $security,
        private readonly UnitRepositoryInterface $repository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function create(CreateUnitTransfer $transfer): Unit
    {
        $user = $this->security->getDomainUser();

        $name = new I18N($transfer->getName());
        $alias = new I18N($transfer->getAlias());

        $suggestions = new Suggestions();

        foreach ($transfer->getSuggestions() as $suggestion) {
            $suggestions->addSuggestions(new Suggestion($suggestion));
        }

        $unit = $this->repository->create($name, $alias, $suggestions, $user);

        $this->entityManager->persist($unit);

        return $unit;
    }
}
