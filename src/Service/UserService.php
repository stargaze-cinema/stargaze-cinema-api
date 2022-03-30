<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\Role;
use App\Parameters\SignUpParameters;
use App\Parameters\UpdateUserParameters;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AbstractEntityService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function hashPassword(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    public function create(SignUpParameters| UpdateUserParameters $params, User $user = new User()): User
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
        } else {
            $user->setRoles([Role::User->value]);
        }

        return $user;
    }
}
