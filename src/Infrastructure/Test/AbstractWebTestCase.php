<?php

declare(strict_types=1);

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
    use CleanModelContextTrait;
    use RegisterGlossaryTrait;

    protected ?KernelBrowser $browser;
    protected ?Generator $faker = null;
    protected static array $ids = [];
    protected static string $locale = 'en';
    private ?EntityManagerInterface $entityManager;

    public function load(object ...$models): void
    {
        $locale = new Locale(static::$locale);

        foreach ($models as $model) {
            foreach ($this->spawnGlossaryFor($model, $locale) as $glossary) {
                $this->entityManager->persist($glossary);
                $this->entityManager->flush();
            }

            $this->entityManager->persist($model);
            $this->entityManager->flush();
        }

        $this->entityManager->clear();
    }

    protected function sendJson(string $method, string $url, array $body): Response
    {
        $server = [
            'HTTP_X_USER_EMAIL' => 'foo@bar.com',
            'HTTP_X_USER_ROLES' => 'core'
        ];

        $this->browser->jsonRequest($method, $url, $body, server: $server);

        return $this->browser->getResponse();
    }

    protected function send(string $method, string $url): Response
    {
        $server = [
            'HTTP_X_USER_EMAIL' => 'foo@bar.com',
            'HTTP_X_USER_ROLES' => 'core'
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
        $this->browser = self::createClient();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->faker = Factory::create();

        Id::setFactory(new IdFactoryStub(
            ...array_map(fn (string $id) => new Uuid($id), static::$ids)
        ));
    }

    protected function tearDown(): void
    {
        $this->entityManager = null;
        $this->browser = null;
        $this->faker = null;
        $this->cleanModelsContexts();
        self::ensureKernelShutdown();
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
    ): void {
        $query = $this->entityManager->getRepository($entity)
            ->createQueryBuilder('c')
            ->select('count(c.id)');

        if ($useSoftDeleteFilter) {
            $query->where('c.deletedAt IS NULL');
        }

        foreach ($criteria as $attribute => $value) {
            $query->andWhere('c.' . $attribute . ' = :' . $value);
            $query->setParameter($value, $value);
        }

        $count = $query->getQuery()->getSingleScalarResult();

        $this->assertEquals($expectedCount, $count);
    }
}
