<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Update;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Unit\Update\Request\UpdateUnitRequest;
use App\Presentation\API\Unit\Update\Response\UpdateUnitResponse;
use App\Shared\Transfer\UpdateUnitTransfer;

#[Route('/units', methods: 'PUT')]
final class UpdateUnitController extends AbstractController
{
    public function __construct(private readonly UnitFacadeInterface $facade)
    {
    }

    public function __invoke(UpdateUnitRequest $request): JsonResponse
    {
        return new UpdateUnitResponse(
            $this->facade->update(UpdateUnitTransfer::fromArray($request->toArray()))
        );
    }
}
