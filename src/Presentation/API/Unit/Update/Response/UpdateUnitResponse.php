<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Update\Response;

use App\Domain\Model\Unit;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class UpdateUnitResponse extends JsonResponse
{
    public function __construct(Unit $unit)
    {
        parent::__construct(Serializer::create()->toArray($unit));
    }
}
