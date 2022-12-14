<?php

declare(strict_types=1);

namespace App\Presentation\API\Product\Create;

use App\Application\Product\ProductFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Product\Create\Request\ProductCreateRequest;
use App\Presentation\API\Product\Create\Response\CreateResponse;
use App\Shared\Transfer\CreateProductTransfer;

#[Route('/products', methods: 'POST')]
final class CreateProductController extends AbstractController
{
    public function __construct(
        private readonly ProductFacadeInterface $productFace,
    ) {
    }

    public function __invoke(ProductCreateRequest $request): JsonResponse
    {
        return new CreateResponse($this->productFace->create(CreateProductTransfer::fromArray($request->toArray())));
    }
}
