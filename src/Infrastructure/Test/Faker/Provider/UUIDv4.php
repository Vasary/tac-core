<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Faker\Provider;

use Faker\Provider\Base;

final class UUIDv4 extends Base
{
    public function uuidv4(): string
    {
        return $this->generateRandomUuid();
    }

    private function generateRandomUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
