<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Create;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Unit\Create\Request\UnitCreateRequest;
use App\Presentation\API\Unit\Create\Response\CreateUnitResponse;
use App\Shared\Transfer\CreateUnitTransfer;

#[Route('/units', methods: 'POST')]
final class CreateUnitController extends AbstractController
{
    public function __construct(
        private readonly UnitFacadeInterface $facade
    ) {
    }

    public function __invoke(UnitCreateRequest $request): JsonResponse
    {
        return new CreateUnitResponse($this->facade->create(CreateUnitTransfer::fromArray($request->toArray())));
    }
}
