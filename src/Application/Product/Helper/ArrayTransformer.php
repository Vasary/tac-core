<?php

declare(strict_types=1);

namespace App\Application\Product\Helper;

use App\Shared\Transfer\AttributeValueTransfer;

final class ArrayTransformer
{
    public static function transform(array $list): array
    {
        $result = [];

        foreach ($list as $attribute) {
            if (is_array($attribute->getValue())) {
                $result[] = new AttributeValueTransfer(
                    null,
                    $attribute->getId(),
                );

                foreach ($attribute->getValue() as $nested) {
                    $result[] = AttributeValueTransfer::fromArray(
                        array_merge($nested, ['parent' => $attribute->getId()])
                    );
                }
            } else {
                $result[] = $attribute;
            }
        }

        return $result;
    }
}
