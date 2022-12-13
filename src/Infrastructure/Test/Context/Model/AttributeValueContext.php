<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Context\Model;

use App\Domain\Model\Attribute;
use App\Domain\Model\AttributeValue;
use App\Domain\Model\Product;
use App\Domain\Model\User;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Id as IdValueObject;
use App\Infrastructure\Test\Context\ContextTrait;
use App\Infrastructure\Test\Context\ModelContextInterface;
use App\Infrastructure\Test\Context\ModelContextTrait;
use App\Infrastructure\Test\Context\StandaloneTrait;
use App\Infrastructure\Test\Context\TimestampTrait;

final class AttributeValueContext implements ModelContextInterface
{
    use ContextTrait;
    use ModelContextTrait;
    use StandaloneTrait;
    use TimestampTrait;

    public string $id = 'dd4b6bef-a52f-4b55-a79c-fdbf6e101808';
    public ?IdValueObject $parent = null;
    public ?string $value = null;
    public User $user;
    public ?Attribute $attribute;
    public ?Product $product = null;

    public function __construct()
    {
        $this->user = UserContext::create()();
        $this->attribute = AttributeContext::create()();
    }

    public function __invoke(bool $theOnlyOne = true): AttributeValue
    {
        /** @var AttributeValue $model */
        $model = $this->getInstance(AttributeValue::class);

        $this
            ->setProperty($model, 'id', Id::fromString($this->id))
            ->setProperty($model, 'attribute', $this->attribute)
            ->setProperty($model, 'value', new AttributeValue\Value($this->value))
            ->setProperty($model, 'creator', $this->user)
            ->setProperty($model, 'product', $this->product)
            ->setProperty($model, 'parent', $this->parent)
            ->setTimestamps($model)
        ;

        return $theOnlyOne ? $this->obtainInstance($model) : $model;
    }
}
