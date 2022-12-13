<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Update;

use App\Application\Category\Business\CategoryFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Category\Update\Request\UpdateCategoryRequest;
use App\Presentation\API\Category\Update\Response\UpdateCategoryResponse;
use App\Shared\Transfer\UpdateCategoryTransfer;

#[Route('/category', methods: 'PUT')]
final class UpdateCategoryController extends AbstractController
{
    public function __construct(private readonly CategoryFacadeInterface $facade)
    {
    }

    public function __invoke(UpdateCategoryRequest $request): JsonResponse
    {
        return new UpdateCategoryResponse(
            $this->facade->update(UpdateCategoryTransfer::fromArray($request->toArray()))
        );
    }
}
