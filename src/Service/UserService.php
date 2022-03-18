<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Parameters\SignUpParameters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private TokenStorageInterface $tokenStorage
    ) {
    }

    public function saveUser(SignUpParameters $params): User
    {
        $user = new User();
        $user->setName($params->getName());
        $user->setEmail($params->getEmail());
        $user->setPassword($this->passwordHasher->hashPassword($user, $params->getPassword()));
        $user->setRoles(['USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function getUserToken(): TokenInterface | null
    {
        return $this->tokenStorage->getToken() ?: null;
    }
}
