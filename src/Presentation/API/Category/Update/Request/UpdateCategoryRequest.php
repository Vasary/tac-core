<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Update\Request;

use App\Infrastructure\Assert\CategoryName;
use App\Infrastructure\Assert\Id;
use App\Infrastructure\HTTP\AbstractRequest;

final class UpdateCategoryRequest extends AbstractRequest
{
    #[Id(true)]
    public mixed $id;

    #[CategoryName(true)]
    public mixed $name;
}
