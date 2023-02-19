<?php

declare(strict_types = 1);

namespace App\Domain\Event;

use App\Domain\Model\Unit;

final class UnitUpdated implements EventInterface
{
    public function __construct(private readonly Unit $unit) {
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }
}
