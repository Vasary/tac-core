<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Context\Model;

use App\Domain\Model\Unit;
use App\Domain\Model\User;
use App\Domain\ValueObject\I18N;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Suggestion;
use App\Domain\ValueObject\Suggestions;
use App\Infrastructure\Test\Context\ContextTrait;
use App\Infrastructure\Test\Context\ModelContextInterface;
use App\Infrastructure\Test\Context\ModelContextTrait;
use App\Infrastructure\Test\Context\StandaloneTrait;
use App\Infrastructure\Test\Context\TimestampTrait;

final class UnitContext implements ModelContextInterface
{
    use ContextTrait;
    use ModelContextTrait;
    use StandaloneTrait;
    use TimestampTrait;

    public string $id = '14c374a0-e8a9-448c-93e5-fea748240266';
    public string $email = 'foo@bar.com';
    public I18N $name;
    public I18N $alias;
    public User $user;
    public array $suggestions = [10, 20, 50];

    public function __construct()
    {
        $this->init();
    }

    private function createSuggestions(): Suggestions
    {
        $suggestions = new Suggestions();

        foreach ($this->suggestions as $suggestion) {
            $suggestions->addSuggestions(new Suggestion($suggestion));
        }

        return $suggestions;
    }

    private function init(): void
    {
        $this->name = new I18N('name');
        $this->alias = new I18N('alias');

        $this->user = UserContext::create()();
    }

    public function __invoke(bool $theOnlyOne = true): Unit
    {
        /** @var Unit $model */
        $model = $this->getInstance(Unit::class);

        $this
            ->setProperty($model, 'id', Id::fromString($this->id))
            ->setProperty($model, 'name', $this->name)
            ->setProperty($model, 'alias', $this->alias)
            ->setProperty($model, 'suggestions', $this->createSuggestions())
            ->setProperty($model, 'creator', $this->user)
            ->setTimestamps($model);

        return $theOnlyOne ? $this->obtainInstance($model) : $model;
    }
}
