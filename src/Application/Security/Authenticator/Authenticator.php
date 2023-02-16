<?php

declare(strict_types = 1);

namespace App\Application\Security\Authenticator;

use App\Application\Security\TokenExtractor\TokenExtractor;
use App\Application\Shared\User as SymfonyUser;
use App\Domain\Repository\UserRepositoryInterface;
use Auth0\SDK\Auth0;
use Auth0\SDK\Exception\InvalidTokenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;

final class Authenticator extends AbstractAuthenticator
{
    private const AUTHORIZATION_HEADER = 'Authorization';

    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly TokenExtractor $tokenExtractor,
        private readonly Auth0 $authService,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::AUTHORIZATION_HEADER);
    }

    public function authenticate(Request $request): Passport
    {
        $token = $this->tokenExtractor->extract($request->headers->get(self::AUTHORIZATION_HEADER));

        try {
            $idToken = $this->authService->decode($token);
        } catch (InvalidTokenException) {
            throw new CustomUserMessageAuthenticationException('Invalid token');
        }

        $roles = ['core'];

        $userBadge = new UserBadge($idToken->getSubject(), fn (string $identifier) => $this->loadUser($identifier, $roles));

        $passport = new SelfValidatingPassport($userBadge);
        $passport->setAttribute('roles', $roles);

        return $passport;
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new PostAuthenticationToken($passport->getUser(), $firewallName, $passport->getAttribute('roles'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'code' => 401,
            'message' => $exception->getMessage(),
        ];

        return new AccessDeniedResponse($data);
    }

    private function loadUser(string $identifier, array $roles): SymfonyUser
    {
        if (null === $user = $this->repository->findBySsoId($identifier)) {
            $user = $this->repository->create($identifier);
        }

        return new SymfonyUser($user, $roles);
    }
}
