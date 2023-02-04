<?php

declare(strict_types=1);

namespace App\Presentation\API\Category\List;

use App\Application\Category\Business\CategoryFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Get;
use App\Infrastructure\OpenAPI\Category\GetCategoriesResponse as OAGetCategoriesResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Category\List\Request\CategoryListRequest;
use App\Presentation\API\Category\List\Response\CategoriesListResponse;

#[Route('/category', methods: 'GET')]
final class CategoriesListController extends AbstractController
{
    public function __construct(private readonly CategoryFacadeInterface $facade)
    {
    }

    #[Get('/api/category')]
    #[OAGetCategoriesResponse]
    #[AccessDeniedResponse]
    public function __invoke(CategoryListRequest $request): JsonResponse
    {
        return new CategoriesListResponse(
            $this->facade->getList($request->page, $request->size),
            $this->facade->getTotalCount()
        );
    }
}
