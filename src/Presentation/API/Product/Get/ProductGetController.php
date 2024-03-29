<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Get;

use App\Application\Product\ProductFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Get;
use App\Infrastructure\OpenAPI\RequestWithId;
use App\Infrastructure\OpenAPI\Product\GetProductResponse as OAGetProductResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Product\Get\Request\ProductGetRequest;
use App\Presentation\API\Product\Get\Response\GetResponse;
use App\Shared\Transfer\GetProductTransfer;

#[Route('/products/{id}', methods: 'GET')]
final class ProductGetController extends AbstractController
{
    public function __construct(private readonly ProductFacadeInterface $productFace)
    {
    }

    #[AccessDeniedResponse]
    #[Get('/api/products/{id}', 'Products')]
    #[OAGetProductResponse]
    #[RequestWithId]
    public function __invoke(ProductGetRequest $request): JsonResponse
    {
        return new GetResponse(
            $this->productFace->findById(GetProductTransfer::fromArray($request->toArray()))
        );
    }
}
