<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Business\EventsLogReader;

use RuntimeException;

final class EventsLogReader implements EventsLogReaderInterface
{
    /**
     * @var resource
     */
    protected $filePointer;

    protected ?Log $currentElement;

    protected int $rowCounter = 0;

    public function __construct(private readonly string $filePath)
    {
        $this->rowCounter = 0;
        $this->currentElement = null;

        if (false === $resource = fopen($this->filePath, 'rb')) {
            throw new RuntimeException('Can\'t open file by path ' . $this->filePath);
        }

        $this->filePointer = $resource;
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
            if (1 !== preg_match('/^\[(?<destination>.+)]:(?<event>{.+)/u', $currentLine, $matches)) {
                if (!isset($matches['destination']) || !isset($matches['event'])) {
                    throw new RuntimeException('Parsing exception');
                }
            }

            $this->currentElement = new Log($matches['destination'], $matches['event']);
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
