<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Create\Response;

use App\Domain\Model\Unit;
use App\Infrastructure\Response\JsonResponse;
use App\Infrastructure\Serializer\Serializer;

final class CreateUnitResponse extends JsonResponse
{
    public function __construct(Unit $unit)
    {
        parent::__construct($this->build($unit), 201);
    }

    private function build(Unit $unit): array
    {
        return Serializer::create()->toArray($unit);
    }
}
