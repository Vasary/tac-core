<?php

declare(strict_types = 1);

namespace App\Infrastructure\Security;

use App\Application\Security\SecurityInterface;
use App\Domain\Model\User;
use Symfony\Component\Security\Core\Security as SymfonySecurity;

final class Security implements SecurityInterface
{
    public function __construct(private readonly SymfonySecurity $security)
    {
    }

    public function getDomainUser(): User
    {
        return $this->security->getUser()->getDomainUser();
    }
}
