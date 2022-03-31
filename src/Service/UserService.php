<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\Role;
use App\Parameters\SignUpParameters;
use App\Parameters\UpdateUserParameters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function hashPassword(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    public function save(SignUpParameters $params): User
    {
        $user = new User();
        $user->setName($params->getName());
        $user->setEmail($params->getEmail());
        $user->setPassword($this->hashPassword($user, $params->getPassword()));
        $user->setRoles([Role::User->value]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update(User $user, UpdateUserParameters $params): User
    {
        if ($name = $params->getName()) {
            $user->setName($name);
        }
        if ($email = $params->getEmail()) {
            $user->setEmail($email);
        }
        if ($password = $params->getPassword()) {
            $user->setPassword($this->hashPassword($user, $password));
        }
        if ($roles = $params->getRoles()) {
            $user->setRoles($roles);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function delete(User $user): bool
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }
}
