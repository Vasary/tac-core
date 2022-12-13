<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute\Type;

use DomainException;
use Stringable;

abstract class AbstractType implements Stringable
{
    protected string $name = '';

    public function __toString(): string
    {
        return empty($this->name) ? throw new DomainException('Type must have a name') : $this->name;
    }
}
