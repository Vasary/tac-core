<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Context\Model;

use App\Domain\Model\Category;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Test\Context\ContextTrait;
use App\Infrastructure\Test\Context\ModelContextInterface;
use App\Infrastructure\Test\Context\ModelContextTrait;
use App\Infrastructure\Test\Context\StandaloneTrait;
use App\Infrastructure\Test\Context\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;

final class CategoryContext implements ModelContextInterface
{
    use ContextTrait;
    use ModelContextTrait;
    use StandaloneTrait;
    use TimestampTrait;

    public string $id = '6b58caa4-0571-44db-988a-8a75f86b2520';
    public I18N $name;
    public User $user;

    public function __construct()
    {
        $this->user = UserContext::create()();
        $this->name = new I18N('name');
    }

    public function __invoke(bool $theOnlyOne = true): Category
    {
        /** @var Category $model */
        $model = $this->getInstance(Category::class);

        $this
            ->setProperty($model, 'id', Id::fromString($this->id))
            ->setProperty($model, 'name', $this->name)
            ->setProperty($model, 'creator', $this->user)
            ->setProperty($model, 'products', new ArrayCollection())
            ->setTimestamps($model);

        return $theOnlyOne ? $this->obtainInstance($model) : $model;
    }
}
