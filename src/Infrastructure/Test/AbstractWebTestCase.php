<?php

declare(strict_types = 1);

namespace App\Infrastructure\Test;

use App\Domain\Model\User as DomainUser;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Locale;
use App\Domain\ValueObject\Uuid;
use App\Infrastructure\Test\Atom\RegisterGlossaryTrait;
use App\Infrastructure\Test\Faker\Factory;
use App\Infrastructure\Test\Stub\IdFactoryStub;
use Auth0\SDK\Auth0;
use Auth0\SDK\Contract\TokenInterface;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use Mockery;
use SlopeIt\ClockMock\ClockMock;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{
    use CleanModelContextTrait, RegisterGlossaryTrait;

    protected static array $ids = [];
    protected static string $locale = 'en';
    protected ?Generator $faker = null;
    private ?KernelBrowser $browser;

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

    protected function sendRequest(string $method, string $url, array $body = []): Response
    {
        $requestHeaders = ['HTTP_AUTHORIZATION' => 'Bearer MTExMTExMTExMTEx'];

        if (in_array($method, [Request::METHOD_POST, Request::METHOD_PUT])) {
            $this->browser->jsonRequest($method, $url, $body, server: $requestHeaders);
        } else {
            $this->browser->request($method, $url, server: $requestHeaders);
        }

        return $this->browser->getResponse();
    }

    protected function freezeTime(string $time = '2022-09-01'): void
    {
        ClockMock::freeze(new \DateTimeImmutable($time));
    }

    protected function withUser(DomainUser $user): void
    {
        $idToken = Mockery::mock(TokenInterface::class);
        $idToken
            ->shouldReceive('getSubject')
            ->once()
            ->andReturn($user->getSsoId())
        ;

        $auth0Mock = Mockery::mock(Auth0::class);
        $auth0Mock
            ->shouldReceive('decode')
            ->once()
            ->andReturn($idToken)
        ;

        self::getContainer()->set(Auth0::class, $auth0Mock);
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
