<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Get\Response;

use App\Domain\Model\Unit;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class GetUnitResponse extends JsonResponse
{
    public function __construct(Unit $unit)
    {
        parent::__construct($this->build($unit));
    }

    private function build(Unit $unit): array
    {
        return Serializer::create()->toArray($unit);
    }
}
