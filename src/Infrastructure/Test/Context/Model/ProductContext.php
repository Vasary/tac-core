<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Context\Model;

use App\Domain\Model\Category;
use App\Domain\Model\Product;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Test\Context\ContextTrait;
use App\Infrastructure\Test\Context\ModelContextInterface;
use App\Infrastructure\Test\Context\ModelContextTrait;
use App\Infrastructure\Test\Context\StandaloneTrait;
use App\Infrastructure\Test\Context\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;

final class ProductContext implements ModelContextInterface
{
    use ContextTrait;
    use ModelContextTrait;
    use StandaloneTrait;
    use TimestampTrait;

    public string $id = '1884fcbf-6ade-49a4-b91a-505290ec1e77';
    public I18N $name;
    public I18N $description;
    public User $user;
    public Category $category;
    public array $attributeValues = [];
    public array $units = [];

    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $this->name = new I18N('name');
        $this->description = new I18N('description');

        $this->user = UserContext::create()();
        $this->category = CategoryContext::create()();
    }

    public function __invoke(bool $theOnlyOne = true): Product
    {
        /** @var Product $model */
        $model = $this->getInstance(Product::class);

        $this
            ->setProperty($model, 'id', Id::fromString($this->id))
            ->setProperty($model, 'name', $this->name)
            ->setProperty($model, 'description', $this->description)
            ->setProperty($model, 'creator', $this->user)
            ->setProperty($model, 'attributes', new ArrayCollection($this->attributeValues))
            ->setProperty($model, 'category', $this->category)
            ->setProperty($model, 'units', new ArrayCollection($this->units))
            ->setTimestamps($model)
        ;

        return $theOnlyOne ? $this->obtainInstance($model) : $model;
    }
}
