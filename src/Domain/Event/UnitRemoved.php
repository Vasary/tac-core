<?php

declare(strict_types = 1);

namespace App\Domain\Event;

use App\Domain\Model\Unit;

final class UnitRemoved implements EventInterface
{
    public function __construct(private readonly Unit $unit) {
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }
}
