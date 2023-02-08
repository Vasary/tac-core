<?php

declare(strict_types = 1);

namespace App\Domain\Factory\UUID;

use App\Domain\Factory\UUID\Builder\BuilderInterface;
use App\Domain\Factory\UUID\Generator\GeneratorInterface;
use App\Domain\ValueObject\Uuid;

final class IdFactory implements IdFactoryInterface
{
    public function __construct(
        private readonly GeneratorInterface $generator,
        private readonly BuilderInterface $builder,
    ) {
    }

    public function v4(): Uuid
    {
        return $this->builder->build($this->generator->generate());
    }

    public function fromString(string $uuidString): Uuid
    {
        return new Uuid($uuidString);
    }
}
