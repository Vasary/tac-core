<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Update\Request;

use App\Infrastructure\Assert\Id;
use App\Infrastructure\Assert\UnitAlias;
use App\Infrastructure\Assert\UnitName;
use App\Infrastructure\Assert\UnitSuggestions;
use App\Infrastructure\HTTP\AbstractRequest;

final class UpdateUnitRequest extends AbstractRequest
{
    #[Id(true)]
    public mixed $id;

    #[UnitName(true)]
    public mixed $name;

    #[UnitAlias(true)]
    public mixed $alias;

    #[UnitSuggestions(true)]
    public mixed $suggestions;
}
