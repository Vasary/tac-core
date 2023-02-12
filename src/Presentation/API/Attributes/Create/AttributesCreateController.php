<?php

declare(strict_types = 1);

namespace App\Presentation\API\Attributes\Create;

use App\Application\Attribute\Business\AttributeFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Attribute\CreateResponse as OACreateResponse;
use App\Infrastructure\OpenAPI\Post;
use App\Infrastructure\OpenAPI\Attribute\CreateRequest;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Attributes\Create\Request\AttributeCreateRequest;
use App\Presentation\API\Attributes\Create\Response\CreateResponse;
use App\Shared\Transfer\AttributeCreateTransfer;

#[Route('/attributes', methods: 'POST')]
final class AttributesCreateController extends AbstractController
{
    public function __construct(
        private readonly AttributeFacadeInterface $attributeFacade,
    ) {
    }

    #[Post('/api/attributes', 'Attributes')]
    #[CreateRequest]
    #[OACreateResponse]
    #[AccessDeniedResponse]
    public function __invoke(AttributeCreateRequest $request): JsonResponse
    {
        $attributeTransfer = AttributeCreateTransfer::fromArray($request->toArray());

        return new CreateResponse($this->attributeFacade->create($attributeTransfer));
    }
}
