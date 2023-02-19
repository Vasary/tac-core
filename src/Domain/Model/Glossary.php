<?php

declare(strict_types = 1);

namespace App\Domain\Model;

use App\Domain\Event\GlossaryCreated;
use App\Domain\Event\GlossaryUpdated;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Locale;

class Glossary implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private Id $id;

    public function __construct(
        private readonly string $field,
        private ?string $value,
        private readonly Locale $locale,
        private readonly Id $parentId,
    ) {
        $this->id = Id::create();
        $this->raise(new GlossaryCreated(clone $this));
    }

    public function field(): string
    {
        return $this->field;
    }

    public function parent(): Id
    {
        return $this->parentId;
    }

    public function locale(): Locale
    {
        return $this->locale;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        $this->raise(new GlossaryUpdated(clone $this));

        return $this;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
