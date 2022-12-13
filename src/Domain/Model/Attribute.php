<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Event\AttributeCreated;
use App\Domain\Event\AttributeRemoved;
use App\Domain\Event\AttributeUpdated;
use App\Domain\Model\Attribute\Type\AbstractType;
use App\Domain\Model\Attribute\Type\ArrayType;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use DateTimeImmutable;

class Attribute implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private Id $id;
    private DateTimeImmutable $updatedAt;
    private ?DateTimeImmutable $deletedAt;
    private readonly DateTimeImmutable $createdAt;

    public function __construct(
        private string $code,
        protected I18N $name,
        protected I18N $description,
        private AbstractType $type,
        private readonly User $creator
    ) {
        $this->id = Id::create();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;

        $this->raise(new AttributeCreated(clone $this));
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): I18N
    {
        return $this->name;
    }

    public function getDescription(): I18N
    {
        return $this->description;
    }

    public function getType(): AbstractType
    {
        return $this->type;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeUpdated(clone $this));

        return $this;
    }

    public function setName(I18N $name): self
    {
        $this->name = $name;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeUpdated(clone $this));

        return $this;
    }

    public function setDescription(I18N $description): self
    {
        $this->description = $description;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeUpdated(clone $this));

        return $this;
    }

    public function setType(AbstractType $type): self
    {
        $this->type = $type;
        $this->updatedAt = new DateTimeImmutable();

        $this->raise(new AttributeUpdated(clone $this));

        return $this;
    }

    public function onRemove(): void
    {
        $this->raise(new AttributeRemoved(clone $this));
    }
}
