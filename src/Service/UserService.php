<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\Role;
use App\Parameters\SignUpParameters;
use App\Parameters\UpdateUserParameters;

class UserService extends AbstractEntityService
{
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
        if (!$params instanceof \App\Parameters\SignUpParameters) {
            if ($roles = $params->getRoles()) {
                $user->setRoles($roles);
            }
        } else {
            $user->setRoles([Role::User->value]);
        }

        return $user;
    }
}
