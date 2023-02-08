<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Context\Model;

use App\Domain\Model\Attribute;
use App\Domain\Model\Attribute\Type\AbstractType;
use App\Domain\Model\Attribute\Type\StringType;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Test\Context\ContextTrait;
use App\Infrastructure\Test\Context\ModelContextInterface;
use App\Infrastructure\Test\Context\ModelContextTrait;
use App\Infrastructure\Test\Context\StandaloneTrait;
use App\Infrastructure\Test\Context\TimestampTrait;

final class AttributeContext implements ModelContextInterface
{
    use ContextTrait;
    use ModelContextTrait;
    use StandaloneTrait;
    use TimestampTrait;

    public string $id = '888c23c6-06fe-4a95-a66c-f292da2f7607';
    public I18N $name;
    public I18N $description;
    public User $user;
    public AbstractType $type;
    public string $code = 'name';

    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $this->user = UserContext::create()();
        $this->type = new StringType();

        $this->name = new I18N('name');
        $this->description = new I18N('description');
    }

    public function __invoke(bool $theOnlyOne = true): Attribute
    {
        /** @var Attribute $model */
        $model = $this->getInstance(Attribute::class);

        $this
            ->setProperty($model, 'id', Id::fromString($this->id))
            ->setProperty($model, 'name', $this->name)
            ->setProperty($model, 'description', $this->description)
            ->setProperty($model, 'creator', $this->user)
            ->setProperty($model, 'type', $this->type)
            ->setProperty($model, 'code', $this->code)
            ->setTimestamps($model);

        return $theOnlyOne ? $this->obtainInstance($model) : $model;
    }
}
