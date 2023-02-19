<?php

declare(strict_types=1);

namespace App\Presentation\API\Product\Delete;

use App\Application\Product\ProductFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Delete;
use App\Infrastructure\OpenAPI\RequestWithId;
use App\Infrastructure\OpenAPI\SuccessfullyDeletedResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Product\Delete\Request\ProductDeleteRequest;
use App\Presentation\API\Product\Delete\Response\DeleteResponse;
use App\Shared\Transfer\DeleteProductTransfer;

#[Route('/products/{id}', methods: 'DELETE')]
class ProductDeleteController extends AbstractController
{
    public function __construct(private readonly ProductFacadeInterface $productFace)
    {
    }

    #[AccessDeniedResponse]
    #[Delete('/api/products/{id}', 'Products')]
    #[RequestWithId]
    #[SuccessfullyDeletedResponse]
    public function __invoke(ProductDeleteRequest $request): JsonResponse
    {
        $this->productFace->delete(DeleteProductTransfer::fromArray($request->toArray()));

        return new DeleteResponse();
    }
}
