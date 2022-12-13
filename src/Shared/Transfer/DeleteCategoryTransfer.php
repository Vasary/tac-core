<?php

declare(strict_types=1);

namespace App\Shared\Transfer;

final class DeleteCategoryTransfer
{
    use CreateFromTrait;

    public function __construct(private readonly string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
