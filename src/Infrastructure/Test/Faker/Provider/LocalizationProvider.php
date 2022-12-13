<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Faker\Provider;

use App\Domain\ValueObject\I18N;
use Faker\Provider\Base;

final class LocalizationProvider extends Base
{
    public function localization(int $length = 25): I18N
    {
        return new I18N($this->generator->regexify('[A-Za-z0-9]{' . $length . '}'));
    }
}
