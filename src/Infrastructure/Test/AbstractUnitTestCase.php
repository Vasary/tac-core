<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test;

use App\Infrastructure\Test\Faker\Factory;
use App\Infrastructure\Test\Faker\Generator;
use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractUnitTestCase extends WebTestCase
{
    use CleanModelContextTrait;

    protected ?Generator $faker = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        ;

        $this->cleanModelsContexts();
        $this->faker = null;
        Mockery::close();
    }
}
