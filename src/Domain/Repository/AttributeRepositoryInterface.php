<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\Attribute;
use App\Domain\Model\Attribute\Type\AbstractType;
use App\Domain\Model\AttributeValue\Code;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use Generator;

interface AttributeRepositoryInterface
{
    public function findByCode(Code $code): ?Attribute;

    public function create(
        string $code,
        I18N $name,
        I18N $description,
        AbstractType $type,
        User $creator
    ): Attribute;

    public function list(int $page, int $size): Generator;

    public function findById(Id $id): ?Attribute;

    public function totalCount(): int;

    public function delete(Attribute $attribute): void;
}
