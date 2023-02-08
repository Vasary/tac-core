<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Update\Request;

use App\Infrastructure\Assert\Attributes;
use App\Infrastructure\Assert\Id;
use App\Infrastructure\Assert\ProductDescription;
use App\Infrastructure\Assert\ProductName;
use App\Infrastructure\Assert\Units;
use App\Infrastructure\HTTP\AbstractRequest;

final class UpdateProductRequest extends AbstractRequest
{
    #[Id()]
    public string $id;

    #[ProductName()]
    public string $name;

    #[ProductDescription()]
    public string $description;

    #[Attributes()]
    public mixed $attributes;

    #[Units()]
    public mixed $units;
}
