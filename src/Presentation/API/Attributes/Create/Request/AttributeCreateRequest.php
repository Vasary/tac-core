<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Create\Request;

use App\Infrastructure\Assert\AttributeDescription;
use App\Infrastructure\Assert\AttributeName;
use App\Infrastructure\Assert\AttributeType;
use App\Infrastructure\Assert\Code;
use App\Infrastructure\HTTP\AbstractRequest;

final class AttributeCreateRequest extends AbstractRequest
{
    #[Code(true)]
    public mixed $code;

    #[AttributeName(true)]
    public mixed $name;

    #[AttributeType(true)]
    public mixed $type;

    #[AttributeDescription(true)]
    public mixed $description;
}
