<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Get;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Unit\Get\Request\GetUnitRequest;
use App\Presentation\API\Unit\Get\Response\GetUnitResponse;
use App\Shared\Transfer\GetUnitTransfer;

#[Route('/units/{id}', methods: 'GET')]
final class GetUnitController extends AbstractController
{
    public function __construct(
        private readonly UnitFacadeInterface $facade,
    ) {
    }

    public function __invoke(GetUnitRequest $request): JsonResponse
    {
        return new GetUnitResponse($this->facade->getUnit(GetUnitTransfer::fromArray($request->toArray())));
    }
}
