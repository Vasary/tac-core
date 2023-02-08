<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\List;

use App\Application\Attribute\Business\AttributeFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Attributes\List\Request\AttributesListRequest;
use App\Presentation\API\Attributes\List\Response\AttributesListResponse;

#[Route('/attributes', methods: 'GET')]
final class AttributesGetListController extends AbstractController
{
    public function __construct(private readonly AttributeFacadeInterface $facade)
    {
    }

    public function __invoke(AttributesListRequest $request): JsonResponse
    {
        return new AttributesListResponse(
            $this->facade->getList($request->page, $request->size),
            $this->facade->getTotalCount()
        );
    }
}
