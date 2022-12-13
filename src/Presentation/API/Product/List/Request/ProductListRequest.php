<?php

declare(strict_types=1);

namespace App\Presentation\API\Product\List\Request;

use App\Infrastructure\Assert\Page;
use App\Infrastructure\Assert\Size;
use App\Infrastructure\HTTP\AbstractRequest;

final class ProductListRequest extends AbstractRequest
{
    #[Page(true)]
    public int $page;

    #[Size(true)]
    public int $size;

    protected function retrieveData(): array
    {
        return [
            'page' => (int) $this->getRequest()->query->get('page'),
            'size' => (int) $this->getRequest()->query->get('size'),
        ];
    }
}
