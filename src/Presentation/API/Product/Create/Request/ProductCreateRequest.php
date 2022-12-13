<?php

declare(strict_types=1);

namespace App\Presentation\API\Product\Create\Request;

use App\Infrastructure\Assert\Attributes;
use App\Infrastructure\Assert\NotBlank;
use App\Infrastructure\Assert\ProductDescription;
use App\Infrastructure\Assert\ProductName;
use App\Infrastructure\Assert\Units;
use App\Infrastructure\HTTP\AbstractRequest;

final class ProductCreateRequest extends AbstractRequest
{
    #[ProductName(true)]
    public mixed $name;

    #[ProductDescription(true)]
    public mixed $description;

    #[NotBlank('category', true)]
    public mixed $category;

    #[Attributes()]
    public mixed $attributes;

    #[Units()]
    public mixed $units;
}
