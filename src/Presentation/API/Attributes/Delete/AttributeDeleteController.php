<?php

declare(strict_types=1);

namespace App\Presentation\API\Attributes\Delete;

use App\Application\Attribute\Business\AttributeFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Attributes\Delete\Request\AttributeDeleteRequest;
use App\Presentation\API\Attributes\Delete\Response\AttributeDeleteResponse;
use App\Shared\Transfer\DeleteAttributeTransfer;

#[Route('/attributes/{id}', methods: 'DELETE')]
final class AttributeDeleteController extends AbstractController
{
    public function __construct(
        private readonly AttributeFacadeInterface $attributeFacade,
    ) {
    }

    public function __invoke(AttributeDeleteRequest $request): JsonResponse
    {
        $this->attributeFacade->delete(DeleteAttributeTransfer::fromArray($request->toArray()));

        return new AttributeDeleteResponse();
    }
}
