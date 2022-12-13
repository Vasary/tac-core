<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Event\UserCreated;
use App\Domain\ValueObject\Id;
use DateTimeImmutable;

class User implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private Id $id;
    private DateTimeImmutable $updatedAt;
    private ?DateTimeImmutable $deletedAt;
    private readonly DateTimeImmutable $createdAt;

    public function __construct(private readonly string $email)
    {
        $this->id = Id::create();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;

        $this->raise(new UserCreated(clone $this));
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
