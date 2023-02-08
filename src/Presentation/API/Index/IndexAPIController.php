<?php

declare(strict_types = 1);

namespace App\Presentation\API\Index;

use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\OpenAPI\Info;
use App\Presentation\API\Index\Response\IndexAPIResponse;

#[Info]
#[Route('/', methods: 'GET')]
final class IndexAPIController extends AbstractController
{
    public function __invoke(): IndexAPIResponse
    {
        return new IndexAPIResponse();
    }
}
