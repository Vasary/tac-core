<?php

declare(strict_types = 1);

namespace App\Presentation\API\AttributeValue\List;

use App\Application\AttributeValue\Business\AttributeValueFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Get;
use App\Infrastructure\OpenAPI\AttributeValue\GetAttributeValuesResponse;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\AttributeValue\List\Request\AttributesValuesListRequest;
use App\Presentation\API\AttributeValue\List\Response\GetResponse;
use App\Infrastructure\OpenAPI\AttributeValue\AttributeSchema;

#[Route('/attributes/values', methods: 'GET')]
final class AttributesGetController extends AbstractController
{
    public function __construct(private readonly AttributeValueFacadeInterface $facade)
    {
    }

    #[AccessDeniedResponse]
    #[AttributeSchema]
    #[Get('/api/attributes/values', 'Attributes values', true)]
    #[GetAttributeValuesResponse]
    public function __invoke(AttributesValuesListRequest $request): JsonResponse
    {
        return new GetResponse(
            $this->facade->list($request->page, $request->size),
            $this->facade->getTotal()
        );
    }
}
