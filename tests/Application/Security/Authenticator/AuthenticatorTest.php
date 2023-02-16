<?php

declare(strict_types = 1);

namespace App\Tests\Application\Security\Authenticator;

use App\Application\Security\Authenticator\AccessDeniedResponse;
use App\Application\Security\Authenticator\Authenticator;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Security\User\UserInterface;
use App\Infrastructure\Test\AbstractUnitTestCase;
use App\Infrastructure\Test\Context\Model\UserContext;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

final class AuthenticatorTest extends AbstractUnitTestCase
{
    public function testShouldSuccessfullyAuthenticateUser(): void
    {
        $user = UserContext::create()();

        $repository = Mockery::mock(UserRepositoryInterface::class);
        $repository
            ->shouldReceive('findBySsoId')
            ->with($user->getSsoId())
            ->andReturn($user)
        ;

        $request = new Request(server: [
            'HTTP_X_USER_EMAIL' => 'foo@bar.com',
            'HTTP_X_USER_ROLES' => 'CORE',
        ]);

        $authenticator = new Authenticator($repository);
        $passport = $authenticator->authenticate($request);
        $token = $authenticator->createToken($passport, 'main');
        $failureResponse = $authenticator->onAuthenticationFailure($request, new AuthenticationException());

        $this->assertArrayHasKey('roles', $passport->getAttributes());
        $this->assertEquals('foo@bar.com', $passport->getUser()->getUserIdentifier());
        $this->assertInstanceOf(UserInterface::class, $passport->getUser());

        $this->assertNull($authenticator->onAuthenticationSuccess($request, $token, 'main'));
        $this->assertInstanceOf(AccessDeniedResponse::class, $failureResponse);
        $this->assertEquals(401, $failureResponse->getStatusCode());
        $this->assertJson($failureResponse->getContent());
    }

    public function testShouldNotAuthenticateUser(): void
    {
        $user = UserContext::create()();

        $repository = Mockery::mock(UserRepositoryInterface::class);
        $repository
            ->shouldReceive('findBySsoId')
            ->with($user->getSsoId())
            ->andReturn(null)
        ;

        $repository
            ->shouldReceive('create')
            ->andReturn($user)
        ;

        $request = new Request(server: [
            'HTTP_X_USER_EMAIL' => 'foo@bar.com',
            'HTTP_X_USER_ROLES' => 'CORE',
        ]);

        $authenticator = new Authenticator($repository);

        $passport = $authenticator->authenticate($request);

        $this->assertArrayHasKey('roles', $passport->getAttributes());
        $this->assertEquals('foo@bar.com', $passport->getUser()->getUserIdentifier());
        $this->assertInstanceOf(UserInterface::class, $passport->getUser());
    }

    public function testShouldNotAuthenticateUserWithNotProvidedParameters(): void
    {
        $this->expectException(CustomUserMessageAuthenticationException::class);

        $repository = Mockery::mock(UserRepositoryInterface::class);

        $request = new Request(server: [
            'HTTP_X_USER_EMAIL' => '',
            'HTTP_X_USER_ROLES' => '',
        ]);

        $authenticator = new Authenticator($repository);

        $authenticator->authenticate($request);
    }
}
