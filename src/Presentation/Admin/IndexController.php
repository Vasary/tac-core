<?php

declare(strict_types=1);

namespace App\Presentation\Admin;

use App\Infrastructure\Annotation\Route;
use App\Infrastructure\Controller\AbstractController;
use App\Presentation\Admin\Response\IndexResponse;

#[Route('/{wildcard}', requirements: ['wildcard' => '.*'], methods: 'GET', )]
final class IndexController extends AbstractController
{
    public function __invoke(): IndexResponse
    {
        return new IndexResponse($this->renderView('@admin/index.html.twig'));
    }
}
