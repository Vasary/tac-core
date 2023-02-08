<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\User;

interface UserRepositoryInterface
{
    public function create(string $email): User;

    public function findByEmail(string $email): ?User;
}
