<?php

declare(strict_types = 1);

namespace App\Domain\Model;

use App\Domain\Event\ProductCreated;
use App\Domain\Event\ProductRemoved;
use App\Domain\Event\ProductUpdated;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Product implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private Id $id;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private ?DateTimeImmutable $deletedAt;
    private Collection $units;
    private Collection $attributes;

    public function __construct(
        protected I18N $name,
        protected I18N $description,
        private readonly User $creator,
        private Category $category
    ) {
        $this->id = Id::create();

        $this->units = new ArrayCollection();
        $this->attributes = new ArrayCollection();

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;

        $this->raise(new ProductCreated(clone $this));
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): I18N
    {
        return $this->name;
    }

    public function getDescription(): I18N
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setName(I18N $name): void
    {
        $this->name = $name;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));
    }

    public function setDescription(I18N $description): void
    {
        $this->description = $description;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));
    }

    public function addUnit(Unit $unit): self
    {
        $this->units->add($unit);
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        $this->units->removeElement($unit);
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));

        return $this;
    }

    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function setUnits(Collection $units): self
    {
        $this->units = $units;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setAttributes(Collection $attributes): self
    {
        $this->attributes = $attributes;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));

        return $this;
    }

    public function addAttribute(AttributeValue $item): self
    {
        $this->attributes->add($item);
        $item->setProduct($this);

        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));

        return $this;
    }

    public function removeAttribute(AttributeValue $item): self
    {
        $this->attributes->removeElement($item);
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new ProductUpdated(clone $this));

        return $this;
    }

    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function onRemove(): void
    {
        $this->raise(new ProductRemoved(clone $this));
    }

    public function __clone()
    {
        $units = $this->getUnits();
        $this->units = new ArrayCollection();

        if (!$units->isEmpty()) {
            foreach ($units as $unit) {
                $this->units->add(clone $unit);
            }
        }
    }
}
