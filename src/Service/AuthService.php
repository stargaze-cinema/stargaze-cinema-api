<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\Role;
use App\Exception\UnauthorizedException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthService
{
    public function __construct(
        private TokenStorageInterface $tokenStorage
    ) {
    }

    /**
     * @throws UnauthorizedException
     */
    private function getUserToken(): ?TokenInterface
    {
        if (!$token = $this->tokenStorage->getToken()) {
            throw new UnauthorizedException();
        }

        return $token;
    }

    private function getCurrentUser(): User
    {
        return $this->getUserToken()->getUser();
    }

    public function authenticatedAsAdmin(): bool
    {
        $roles = $this->getCurrentUser()->getRoles();
        if (!in_array(Role::Admin->value, $roles)) {
            return false;
        }

        return true;
    }

    public function authenticatedAsModer(): bool
    {
        $roles = $this->getCurrentUser()->getRoles();
        if (!in_array(Role::Moder->value, $roles)) {
            return false;
        }

        return true;
    }
}
