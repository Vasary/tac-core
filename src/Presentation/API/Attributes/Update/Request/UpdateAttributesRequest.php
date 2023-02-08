<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Update\Request;

use App\Infrastructure\Assert\AttributeDescription;
use App\Infrastructure\Assert\AttributeName;
use App\Infrastructure\Assert\AttributeType;
use App\Infrastructure\Assert\Code;
use App\Infrastructure\Assert\Id;
use App\Infrastructure\Assert\Locale;
use App\Infrastructure\HTTP\AbstractRequest;

final class UpdateAttributesRequest extends AbstractRequest
{
    #[Id(true)]
    public mixed $id;

    #[Code(true)]
    public mixed $code;

    #[AttributeName(true)]
    public mixed $name;

    #[AttributeType(true)]
    public mixed $type;

    #[AttributeDescription(true)]
    public mixed $description;
}
