<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Create;

use App\Application\Product\ProductFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Post;
use App\Infrastructure\OpenAPI\Product\CreateRequest;
use App\Infrastructure\OpenAPI\Product\CreateResponse as OACreateResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Product\Create\Request\ProductCreateRequest;
use App\Presentation\API\Product\Create\Response\CreateResponse;
use App\Shared\Transfer\CreateProductTransfer;

#[Route('/products', methods: 'POST')]
final class CreateProductController extends AbstractController
{
    public function __construct(private readonly ProductFacadeInterface $productFace,)
    {
    }

    #[AccessDeniedResponse]
    #[CreateRequest]
    #[OACreateResponse]
    #[Post('/api/products', 'Products')]
    public function __invoke(ProductCreateRequest $request): JsonResponse
    {
        return new CreateResponse($this->productFace->create(CreateProductTransfer::fromArray($request->toArray())));
    }
}
