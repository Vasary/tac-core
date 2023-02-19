<?php

declare(strict_types = 1);

namespace App\Domain\Model;

use App\Domain\Event\CategoryCreated;
use App\Domain\Event\CategoryRemoved;
use App\Domain\Event\CategoryUpdated;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Category implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private Id $id;
    private DateTimeImmutable $updatedAt;
    private ?DateTimeImmutable $deletedAt;
    private readonly DateTimeImmutable $createdAt;
    private Collection $products;

    public function __construct(protected I18N $name, private readonly User $creator,) {
        $this->id = Id::create();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;
        $this->products = new ArrayCollection();

        $this->raise(new CategoryCreated(clone $this));
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

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setName(I18N $name): self
    {
        $this->name = $name;

        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new CategoryUpdated(clone $this));

        return $this;
    }

    public function onRemove(): void
    {
        $this->raise(new CategoryRemoved(clone $this));
    }
}
