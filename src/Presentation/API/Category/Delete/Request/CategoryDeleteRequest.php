<?php

declare(strict_types = 1);

namespace App\Presentation\API\Category\Delete\Request;

use App\Infrastructure\Assert\Id;
use App\Infrastructure\HTTP\AbstractRequest;

final class CategoryDeleteRequest extends AbstractRequest
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
