<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\Get;

use App\Application\Category\Business\CategoryFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Category\Get\Request\CategoryGetRequest;
use App\Presentation\API\Category\Get\Response\GetResponse;
use App\Shared\Transfer\GetCategoryTransfer;

#[Route('/category/{id}', methods: 'GET')]
final class CategoryGetController extends AbstractController
{
    public function __construct(
        private readonly CategoryFacadeInterface $facade,
    ) {
    }

    public function __invoke(CategoryGetRequest $request): JsonResponse
    {
        return new GetResponse($this->facade->getById(GetCategoryTransfer::fromArray($request->toArray())));
    }
}
