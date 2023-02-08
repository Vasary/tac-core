<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test;

use App\Application\Shared\User as ApplicationUser;
use App\Domain\Model\User as DomainUser;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Locale;
use App\Domain\ValueObject\Uuid;
use App\Infrastructure\Test\Atom\RegisterGlossaryTrait;
use App\Infrastructure\Test\Faker\Factory;
use App\Infrastructure\Test\Stub\IdFactoryStub;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use Mockery;
use SlopeIt\ClockMock\ClockMock;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{
    use CleanModelContextTrait, RegisterGlossaryTrait;

    protected static array $ids = [];
    protected static string $locale = 'en';
    protected ?KernelBrowser $browser;
    protected ?Generator $faker = null;

    public function load(object ...$models): void
    {
        $locale = new Locale(static::$locale);
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        foreach ($models as $model) {
            foreach ($this->spawnGlossaryFor($model, $locale) as $glossary) {
                $entityManager->persist($glossary);
                $entityManager->flush();
            }

            $entityManager->persist($model);
            $entityManager->flush();
        }

        $entityManager->clear();
    }

    protected function sendJson(string $method, string $url, array $body): Response
    {
        $server = [
            'HTTP_X_USER_EMAIL' => 'foo@bar.com',
            'HTTP_X_USER_ROLES' => 'core',
        ];

        $this->browser->jsonRequest($method, $url, $body, server: $server);

        return $this->browser->getResponse();
    }

    protected function send(string $method, string $url): Response
    {
        $server = [
            'HTTP_X_USER_EMAIL' => 'foo@bar.com',
            'HTTP_X_USER_ROLES' => 'core',
        ];

        $this->browser->jsonRequest($method, $url, server: $server);

        return $this->browser->getResponse();
    }

    protected function freezeTime(string $time = '2022-09-01'): void
    {
        ClockMock::freeze(new \DateTimeImmutable($time));
    }

    protected function withUser(DomainUser $user, array $roles = ['ROLE_CORE']): void
    {
        $this->browser->loginUser(new ApplicationUser($user, $roles));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->browser = static::createClient();
        $this->faker = Factory::create();

        Id::setFactory(new IdFactoryStub(
            ...array_map(fn(string $id) => new Uuid($id), static::$ids)
        ));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->browser = null;
        $this->faker = null;

        $this->cleanModelsContexts();

        ClockMock::reset();
        Mockery::close();

        if (!Id::getFactory()->isEmpty()) {
            $this->fail('There are some unused UUID left in StubFactory');
        }

        Id::setFactory(null);
    }

    protected function assertDatabaseCount(
        string $entity,
        int    $expectedCount,
        array  $criteria = [],
        bool   $useSoftDeleteFilter = true
    ): void
    {
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $query = $entityManager->getRepository($entity)
            ->createQueryBuilder('c')
            ->select('count(c.id)');

        if ($useSoftDeleteFilter) {
            $query->where('c.deletedAt IS NULL');
        }

        foreach ($criteria as $attribute => $value) {
            $query->andWhere('c.' . $attribute . ' = :' . $value);
            $query->setParameter($value, $value);
        }

        $this->assertEquals($expectedCount, $query->getQuery()->getSingleScalarResult());
    }
}
