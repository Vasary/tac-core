<?php

declare(strict_types=1);

namespace App\Application\DomainEvent\Business\EventsLogReader;

final class EventsLogReader implements EventsLogReaderInterface
{
    protected $filePointer;

    protected ?Log $currentElement;

    protected int $rowCounter = 0;

    public function __construct(private readonly string $filePath)
    {
        $this->rowCounter = 0;
        $this->currentElement = null;
        $this->filePointer = fopen($this->filePath, 'rb');
    }

    public function valid(): bool
    {
        if (!$this->next()) {
            if (is_resource($this->filePointer)) {
                fclose($this->filePointer);
            }

            return false;
        }

        return true;
    }

    public function rewind(): void
    {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }

    public function next(): bool
    {
        if (is_resource($this->filePointer)) {
            return !feof($this->filePointer);
        }

        return false;
    }

    public function current(): ?Log
    {
        $currentLine = fgets($this->filePointer);

        if (false !== $currentLine) {
            $logData = preg_split('/(.+),({.+)/u', $currentLine);


            $this->currentElement = new Log($logData[0], $logData[1]);
            $this->rowCounter++;
        } else {
            $this->currentElement = null;
        }

        return $this->currentElement;
    }

    public function key(): int
    {
        return $this->rowCounter;
    }
}
