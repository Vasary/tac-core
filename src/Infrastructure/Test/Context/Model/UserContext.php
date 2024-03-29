<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test\Context\Model;

use App\Domain\Model\User;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Test\Context\ContextTrait;
use App\Infrastructure\Test\Context\ModelContextInterface;
use App\Infrastructure\Test\Context\ModelContextTrait;
use App\Infrastructure\Test\Context\StandaloneTrait;
use App\Infrastructure\Test\Context\TimestampTrait;

final class UserContext implements ModelContextInterface
{
    use ContextTrait;
    use ModelContextTrait;
    use StandaloneTrait;
    use TimestampTrait;

    public string $id = '6b58caa4-0571-44db-988a-8a75f86b2520';
    public string $ssoId = 'mock|10101011';

    public function __invoke(bool $theOnlyOne = true): User
    {
        /** @var User $model */
        $model = $this->getInstance(User::class);

        $this
            ->setProperty($model, 'id', Id::fromString($this->id))
            ->setProperty($model, 'ssoId', $this->ssoId)
            ->setTimestamps($model);

        return $theOnlyOne ? $this->obtainInstance($model) : $model;
    }
}
