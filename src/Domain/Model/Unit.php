<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Event\UnitCreated;
use App\Domain\Event\UnitRemoved;
use App\Domain\Event\UnitUpdated;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Suggestions;
use DateTimeImmutable;

class Unit implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private Id $id;
    private DateTimeImmutable $updatedAt;
    private ?DateTimeImmutable $deletedAt;
    private readonly DateTimeImmutable $createdAt;

    public function __construct(
        protected I18N          $name,
        protected I18N          $alias,
        private Suggestions   $suggestions,
        private readonly User $creator,
    ) {
        $this->id = Id::create();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;

        $this->raise(new UnitCreated(clone $this));
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getName(): I18N
    {
        return $this->name;
    }

    public function getSuggestions(): Suggestions
    {
        return $this->suggestions;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setName(I18N $localization): self
    {
        $this->name = $localization;

        $this->updatedAt = new DateTimeImmutable();
        $this->raise(new UnitUpdated(clone $this));

        return $this;
    }

    public function setAlias(I18N $localization): self
    {
        $this->alias = $localization;

        $this->updatedAt = new DateTimeImmutable();
        $this->raise(new UnitUpdated(clone $this));

        return $this;
    }

    public function setSuggestions(Suggestions $suggestions): self
    {
        $this->suggestions = $suggestions;

        $this->updatedAt = new DateTimeImmutable();
        $this->raise(new UnitUpdated(clone $this));

        return $this;
    }

    public function getAlias(): I18N
    {
        return $this->alias;
    }

    public function onRemove(): void
    {
        $this->raise(new UnitRemoved(clone $this));
    }
}
