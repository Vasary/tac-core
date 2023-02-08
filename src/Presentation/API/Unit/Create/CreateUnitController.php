<?php

declare(strict_types = 1);

namespace App\Presentation\API\Unit\Create;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Post;
use App\Infrastructure\OpenAPI\Unit\CreateRequest;
use App\Infrastructure\OpenAPI\Unit\CreateResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Unit\Create\Request\UnitCreateRequest;
use App\Presentation\API\Unit\Create\Response\CreateUnitResponse;
use App\Shared\Transfer\CreateUnitTransfer;

#[Route('/units', methods: 'POST')]
final class CreateUnitController extends AbstractController
{
    public function __construct(
        private readonly UnitFacadeInterface $facade
    )
    {
    }

    #[Post('/api/units')]
    #[CreateRequest]
    #[CreateResponse]
    #[AccessDeniedResponse]
    public function __invoke(UnitCreateRequest $request): JsonResponse
    {
        return new CreateUnitResponse($this->facade->create(CreateUnitTransfer::fromArray($request->toArray())));
    }
}
