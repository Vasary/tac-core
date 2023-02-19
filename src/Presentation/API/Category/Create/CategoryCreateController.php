<?php

declare(strict_types = 1);

namespace App\Presentation\API\Category\Create;

use App\Application\Category\Business\CategoryFacadeInterface;
use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\AccessDeniedResponse;
use App\Infrastructure\OpenAPI\Category\CreateRequest;
use App\Infrastructure\OpenAPI\Category\CreateResponse;
use App\Infrastructure\OpenAPI\Post;
use App\Infrastructure\Response\JsonResponse;
use App\Presentation\API\Category\Create\Request\CategoryCreateRequest;
use App\Presentation\API\Category\Create\Response\CategoryCreateResponse;
use App\Shared\Transfer\CategoryCreateTransfer;

#[Route('/category', methods: 'POST')]
final class CategoryCreateController extends AbstractController
{
    public function __construct(private readonly CategoryFacadeInterface $facade)
    {
    }

    #[AccessDeniedResponse]
    #[CreateRequest]
    #[CreateResponse]
    #[Post('/api/category', 'Category')]
    public function __invoke(CategoryCreateRequest $request): JsonResponse
    {
        return new CategoryCreateResponse(
            $this->facade->create(CategoryCreateTransfer::fromArray($request->toArray()))
        );
    }
}
