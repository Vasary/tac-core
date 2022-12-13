<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Faker\Provider;

use App\Domain\Model\Attribute;
use App\Infrastructure\Test\Context\Model\AttributeContext;
use Faker\Provider\Base;

final class AttributeProvider extends Base
{
    public function attribute(): Attribute
    {
        $context = AttributeContext::create();

        $context->name = $this->generator->localization(25);
        $context->description = $this->generator->localization(200);
        $context->code = $this->generator->regexify('[A-Za-z0-9]{10}');
        $context->id = $this->generator->uuidv4();

        return $context();
    }
}
