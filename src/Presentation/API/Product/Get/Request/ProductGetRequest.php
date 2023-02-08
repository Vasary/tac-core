<?php

declare(strict_types = 1);

namespace App\Presentation\API\Product\Get\Request;

use App\Infrastructure\Assert\Id;
use App\Infrastructure\HTTP\AbstractRequest;

final class ProductGetRequest extends AbstractRequest
{
    #[Id(true)]
    public mixed $id;

    protected function retrieveData(): array
    {
        return [
            'id' => $this->getRequest()->attributes->get('id'),
        ];
    }
}
