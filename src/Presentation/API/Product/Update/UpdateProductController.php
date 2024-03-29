<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Update;

use App\Application\Product\ProductFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Product\UpdateRequest;
use App\Infrastructure\OpenAPI\Product\UpdateResponse as OAUpdateResponse;
use App\Infrastructure\OpenAPI\Put;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Product\Update\Request\UpdateProductRequest;
use App\Presentation\API\Product\Update\Response\UpdateProductResponse;
use App\Shared\Transfer\UpdateProductTransfer;

#[Route('/products', methods: 'PUT')]
final class UpdateProductController extends AbstractController
{
    public function __construct(private readonly ProductFacadeInterface $facade)
    {
    }

    #[AccessDeniedResponse]
    #[OAUpdateResponse]
    #[Put('/api/products', 'Products')]
    #[UpdateRequest]
    public function __invoke(UpdateProductRequest $request): JsonResponse
    {
        return new UpdateProductResponse($this->facade->update(UpdateProductTransfer::fromArray($request->toArray())));
    }
}
