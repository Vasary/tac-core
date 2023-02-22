<?php

declare(strict_types=1);

namespace App\Application\HealthCheck\Communication\Plugins;

use App\Application\HealthCheck\Business\Checker\HealthCheckerPluginInterface;
use App\Application\HealthCheck\Business\Checker\Response;
use Psr\Container\ContainerInterface;
use Throwable;

final class DoctrineConnectionCheckerPlugin implements HealthCheckerPluginInterface
{
    private const CHECK_RESULT_NAME = 'doctrine';

    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function check(): Response
    {
        if ($this->container->has('doctrine.orm.entity_manager') === false) {
            return new Response(self::CHECK_RESULT_NAME, false, 'Entity Manager Not Found.');
        }

        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        if ($entityManager === null) {
            return new Response(self::CHECK_RESULT_NAME, false, 'Entity Manager Not Found.');
        }

        try {
            $con = $entityManager->getConnection();
            $con->executeQuery($con->getDatabasePlatform()->getDummySelectSQL())->free();
        } catch (Throwable $e) {
            return new Response(self::CHECK_RESULT_NAME, false, $e->getMessage());
        }

        return new Response(self::CHECK_RESULT_NAME, true, 'ok');
    }
}
