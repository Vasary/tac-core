<?php

declare(strict_types = 1);

namespace App\Application\Security\Authenticator;

use App\Application\Shared\User as SymfonyUser;
use App\Domain\Repository\UserRepositoryInterface;
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
    private const X_USER_IDENTIFIER_HEADER = 'x-user-email';
    private const X_USER_ROLES_HEADER = 'x-user-roles';

    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::X_USER_IDENTIFIER_HEADER)
            && $request->headers->has(self::X_USER_ROLES_HEADER);
    }

    public function authenticate(Request $request): Passport
    {
        $userEmail = $request->headers->get(self::X_USER_IDENTIFIER_HEADER);
        $userRoles = $request->headers->get(self::X_USER_ROLES_HEADER, 'core');

        if (empty($userEmail) || empty($userRoles)) {
            throw new CustomUserMessageAuthenticationException();
        }

        $roles = array_map(
            fn (string $roleName) => sprintf('ROLE_%s', mb_strtoupper($roleName)),
            array_filter(explode(',', $userRoles))
        );

        $userBadge = new UserBadge($userEmail, fn (string $identifier) => $this->loadUser($identifier, $roles));

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
        if (null === $user = $this->repository->findByEmail($identifier)) {
            $user = $this->repository->create($identifier);
        }

        return new SymfonyUser($user, $roles);
    }
}
