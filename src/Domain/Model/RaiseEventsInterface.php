<?php

declare(strict_types = 1);

namespace App\Domain\Model;

interface RaiseEventsInterface
{
    public function popEvents(): array;
}
