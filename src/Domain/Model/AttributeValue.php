<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Event\AttributeValueCreated;
use App\Domain\Event\AttributeValueRemoved;
use App\Domain\Event\AttributeValueUpdated;
use App\Domain\Model\AttributeValue\Value;
use App\Domain\ValueObject\Id;
use DateTimeImmutable;

class AttributeValue implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private readonly Id $id;
    private readonly DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private ?DateTimeImmutable $deletedAt;
    private ?Product $product;

    public function __construct(
        private readonly Attribute $attribute,
        private Value $value,
        private readonly User $creator,
        private ?Id $parent = null,
    ) {
        $this->id = Id::create();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;
        $this->product = null;

        $this->raise(new AttributeValueCreated(clone $this));
    }

    public function getId(): Id
    {
        return $this->id;
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

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function getParent(): ?Id
    {
        return $this->parent;
    }

    public function setParent(?Id $id): self
    {
        $this->parent = $id;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeValueUpdated(clone $this));

        return $this;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setValue(Value $value): self
    {
        $this->value = $value;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeValueUpdated(clone $this));

        return $this;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeValueUpdated(clone $this));

        return $this;
    }

    public function onRemove(): void
    {
        $this->raise(new AttributeValueRemoved(clone $this));
    }
}
