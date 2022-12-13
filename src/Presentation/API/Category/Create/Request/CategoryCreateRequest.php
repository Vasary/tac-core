<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Create\Request;

use App\Infrastructure\Assert\CategoryName;
use App\Infrastructure\HTTP\AbstractRequest;

final class CategoryCreateRequest extends AbstractRequest
{
    #[CategoryName(true)]
    public mixed $name;
}
