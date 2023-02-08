<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Faker\Provider;

use App\Domain\Model\Unit;
use App\Infrastructure\Test\Context\Model\UnitContext;
use Faker\Provider\Base;

final class UnitProvider extends Base
{
    public function unit(?string $id = null): Unit
    {
        $unit = UnitContext::create();
        $unit->id = null === $id ? $this->generator->uuidv4() : $id;
        $unit->name = $this->generator->localization(5);
        $unit->alias = $this->generator->localization(1);

        return $unit();
    }
}
