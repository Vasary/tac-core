<?php

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
