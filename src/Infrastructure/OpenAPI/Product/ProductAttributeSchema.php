<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAPI\Product;

use App\Infrastructure\Map\ParametersList;
use OpenApi\Attributes as OA;
use Attribute;

final class ProductAttributeSchema extends OA\Schema
{
    public function __construct()
    {
        parent::__construct(
            properties: [
                new OA\Property(
                    property: ParametersList::VALUE,
                    description: 'Attribute value',
                    type: 'string',
                    example: 'frozen',
                ),
                new OA\Property(
                    property: ParametersList::ID,
                    description: 'Attribute id',
                    type: 'string',
                    example: '3692c17b-f95f-462a-bc56-6fab59c0091e'
                ),
                new OA\Property(
                    property: ParametersList::PARENT,
                    description: 'Parent attribute id',
                    type: 'string',
                    example: '305b2ffe-2084-43c8-b265-086ea7b944d7',
                    nullable: true
                )
            ]
        );
    }
}
