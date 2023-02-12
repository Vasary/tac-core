<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\List;

use App\Application\Product\ProductFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Get;
use App\Infrastructure\OpenAPI\Product\GetProductsResponse as OAGetProductsResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Product\List\Request\ProductListRequest;
use App\Presentation\API\Product\List\Response\ListResponse;

#[Route('/products', methods: 'GET')]
final class ProductGetListController extends AbstractController
{
    public function __construct(private readonly ProductFacadeInterface $facade)
    {
    }

    #[Get('/api/products', 'Products')]
    #[OAGetProductsResponse]
    #[AccessDeniedResponse]
    public function __invoke(ProductListRequest $request): JsonResponse
    {
        return new ListResponse(
            $this->facade->getList($request->page, $request->size),
            $this->facade->getTotalCount()
        );
    }
}
