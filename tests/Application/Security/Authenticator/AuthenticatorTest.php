<?php

declare(strict_types=1);

namespace App\Tests\Application\Security\Authenticator;

use App\Application\Security\Authenticator\AccessDeniedResponse;
use App\Application\Security\Authenticator\Authenticator;
use App\Application\Security\TokenExtractor\TokenExtractor;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Security\User\UserInterface;
use App\Infrastructure\Test\AbstractUnitTestCase;
use App\Infrastructure\Test\Context\Model\UserContext;
use Auth0\SDK\Auth0;
use Auth0\SDK\Contract\TokenInterface;
use Auth0\SDK\Exception\InvalidTokenException;
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
            ->andReturn($user);

        $request = new Request(server: [
            'HTTP_Authorization' => 'Bearer valid-token-body',
        ]);

        $auth0 = $this->createAuth0Mock($user->getSsoId());

        $authenticator = new Authenticator($repository, new TokenExtractor(), $auth0);
        $passport = $authenticator->authenticate($request);
        $token = $authenticator->createToken($passport, 'main');
        $failureResponse = $authenticator->onAuthenticationFailure($request, new AuthenticationException());

        $this->assertArrayHasKey('roles', $passport->getAttributes());
        $this->assertEquals('mock|10101011', $passport->getUser()->getUserIdentifier());
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
            ->andReturn(null);

        $repository
            ->shouldReceive('create')
            ->andReturn($user);

        $request = new Request(server: [
            'HTTP_Authorization' => 'Bearer valid-token-body',
        ]);

        $auth0 = $this->createAuth0Mock($user->getSsoId());
        $authenticator = new Authenticator($repository, new TokenExtractor(), $auth0);

        $passport = $authenticator->authenticate($request);

        $this->assertArrayHasKey('roles', $passport->getAttributes());
        $this->assertEquals('mock|10101011', $passport->getUser()->getUserIdentifier());
        $this->assertInstanceOf(UserInterface::class, $passport->getUser());
    }

    public function testShouldNotAuthenticateUserWithNotProvidedParameters(): void
    {
        $this->expectException(CustomUserMessageAuthenticationException::class);

        $repository = Mockery::mock(UserRepositoryInterface::class);

        $request = new Request(server: [
            'HTTP_Authorization' => 'Bearer invalid-token',
        ]);

        $auth0 = Mockery::mock(Auth0::class);
        $auth0
            ->shouldReceive('decode')
            ->once()
            ->andThrow(InvalidTokenException::class);

        $authenticator = new Authenticator($repository, new TokenExtractor(), $auth0);

        $authenticator->authenticate($request);
    }

    private function createAuth0Mock(string $ssoId): Auth0 & Mockery\LegacyMockInterface
    {
        $idTokenMock = Mockery::mock(TokenInterface::class);
        $idTokenMock
            ->shouldReceive('getSubject')
            ->once()
            ->andReturn($ssoId);

        $auth0 = Mockery::mock(Auth0::class);
        $auth0
            ->shouldReceive('decode')
            ->once()
            ->with('valid-token-body')
            ->andReturn($idTokenMock);

        return $auth0;
    }
}
