<?php

declare(strict_types=1);

namespace App\Presentation\API\Unit\List;

use App\Application\Unit\Business\UnitFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Unit\List\Request\UnitsListRequest;
use App\Presentation\API\Unit\List\Response\UnitsListResponse;

#[Route('/units', methods: 'GET')]
final class GetUnitsListController extends AbstractController
{
    public function __construct(private readonly UnitFacadeInterface $facade)
    {
    }

    public function __invoke(UnitsListRequest $request): JsonResponse
    {
        return new UnitsListResponse(
            $this->facade->getList($request->page, $request->size),
            $this->facade->getTotalCount(),
        );
    }
}
