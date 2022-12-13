<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Delete;

use App\Application\Category\Business\CategoryFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Category\Delete\Request\CategoryDeleteRequest;
use App\Presentation\API\Category\Delete\Response\CategoryDeleteResponse;
use App\Shared\Transfer\DeleteCategoryTransfer;

#[Route('/category/{id}', methods: 'DELETE')]
final class CategoryDeleteController extends AbstractController
{
    public function __construct(
        private readonly CategoryFacadeInterface $facade,
    ) {
    }

    public function __invoke(CategoryDeleteRequest $request): JsonResponse
    {
        $this->facade->delete(DeleteCategoryTransfer::fromArray($request->toArray()));

        return new CategoryDeleteResponse();
    }
}
