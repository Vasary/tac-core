<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Update;

use App\Application\Attribute\Business\AttributeFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Put;
use App\Infrastructure\OpenAPI\Attribute\UpdateRequest;
use App\Infrastructure\OpenAPI\Attribute\UpdateResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Attributes\Update\Request\UpdateAttributesRequest;
use App\Presentation\API\Attributes\Update\Response\UpdateAttributesResponse;
use App\Shared\Transfer\UpdateAttributeTransfer;

#[Route('/attributes', methods: 'PUT')]
final class AttributesUpdateController extends AbstractController
{
    public function __construct(private readonly AttributeFacadeInterface $facade)
    {
    }

    #[AccessDeniedResponse]
    #[Put('/api/attributes', 'Attributes')]
    #[UpdateRequest]
    #[UpdateResponse]
    public function __invoke(UpdateAttributesRequest $request): JsonResponse
    {
        return new UpdateAttributesResponse(
            $this->facade->update(UpdateAttributeTransfer::fromArray($request->toArray()))
        );
    }
}
