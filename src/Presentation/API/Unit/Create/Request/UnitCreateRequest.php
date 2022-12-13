<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Create\Request;

use App\Infrastructure\Assert\UnitAlias;
use App\Infrastructure\Assert\UnitName;
use App\Infrastructure\Assert\UnitSuggestions;
use App\Infrastructure\HTTP\AbstractRequest;

final class UnitCreateRequest extends AbstractRequest
{
    #[UnitName(true)]
    public mixed $name;

    #[UnitAlias(true)]
    public mixed $alias;

    #[UnitSuggestions(true)]
    public mixed $suggestions;
}
