<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\Glossary;

final class GlossaryCreated implements EventInterface
{
    public function __construct(
        private readonly Glossary $glossary
    ) {
    }

    public function getGlossary(): Glossary
    {
        return $this->glossary;
    }
}
