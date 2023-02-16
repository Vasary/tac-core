<?php

declare(strict_types = 1);

namespace App\Application\Shared;

use App\Domain\Model\User as DomainUser;
use App\Infrastructure\Security\User\UserInterface;

final class User implements UserInterface
{
    public function __construct(private readonly DomainUser $domainUser, private readonly array $roles)
    {
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->domainUser->getSsoId();
    }

    public function getDomainUser(): DomainUser
    {
        return $this->domainUser;
    }
}
