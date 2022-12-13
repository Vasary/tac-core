<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class UserRepository implements UserRepositoryInterface
{
    private ObjectRepository $objectRepository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $entityManager->getRepository(User::class);
    }

    public function create(string $email): User
    {
        $user = new User($email);

        $this->entityManager->persist($user);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->objectRepository->findOneBy([
            'email' => $email,
        ]);
    }
}
