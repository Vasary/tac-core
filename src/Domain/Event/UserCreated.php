<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\User;

final class UserCreated implements EventInterface
{
    public function __construct(
        private readonly User $user
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
