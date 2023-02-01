<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\Delete;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Delete;
use App\Infrastructure\OpenAPI\RequestWithId;
use App\Infrastructure\OpenAPI\SuccessfullyDeletedResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Unit\Delete\Request\UnitDeleteRequest;
use App\Presentation\API\Unit\Delete\Response\UnitDeleteResponse;
use App\Shared\Transfer\DeleteUnitTransfer;

#[Route('/units/{id}', methods: 'DELETE')]
final class UnitDeleteController extends AbstractController
{
    public function __construct(
        private readonly UnitFacadeInterface $facade,
    ) {
    }

    #[Delete('/api/units/{id}')]
    #[RequestWithId]
    #[SuccessfullyDeletedResponse]
    #[AccessDeniedResponse]
    public function __invoke(UnitDeleteRequest $request): JsonResponse
    {
        $this->facade->delete(DeleteUnitTransfer::fromArray($request->toArray()));

        return new UnitDeleteResponse();
    }
}
