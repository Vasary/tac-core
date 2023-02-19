<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Get;

use App\Application\Attribute\Business\AttributeFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Get;
use App\Infrastructure\OpenAPI\RequestWithId;
use App\Infrastructure\OpenAPI\Attribute\GetAttributeResponse as OAGetAttributeResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Attributes\Get\Request\AttributeGetRequest;
use App\Presentation\API\Attributes\Get\Response\GetResponse;
use App\Shared\Transfer\GetAttributeTransfer;

#[Route('/attributes/{id}', methods: 'GET')]
final class AttributeGetController extends AbstractController
{
    public function __construct(private readonly AttributeFacadeInterface $attributeFacade,) {
    }

    #[AccessDeniedResponse]
    #[Get('/api/attributes/{id}', 'Attributes')]
    #[OAGetAttributeResponse]
    #[RequestWithId]
    public function __invoke(AttributeGetRequest $request): JsonResponse
    {
        return new GetResponse($this->attributeFacade->getById(GetAttributeTransfer::fromArray($request->toArray())));
    }
}
