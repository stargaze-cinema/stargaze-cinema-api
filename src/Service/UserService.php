<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Parameters\SignUpParameters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function saveUser(SignUpParameters $params): User
    {
        $user = new User();
        $user->setName($params->getName());
        $user->setEmail($params->getEmail());
        $user->setPassword($this->passwordHasher->hashPassword($user, $params->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
