<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Business\EventsLogReader;

use Iterator;
use ReturnTypeWillChange;

interface EventsLogReaderInterface extends Iterator
{
    #[ReturnTypeWillChange]
    public function next(): bool;

    #[ReturnTypeWillChange]
    public function current(): ?Log;
}
