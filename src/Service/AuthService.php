<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthService
{
    public function __construct(
        private TokenStorageInterface $tokenStorage
    ) {
    }

    private function getUserToken(): TokenInterface | null
    {
        return $this->tokenStorage->getToken() ?: null;
    }

    public function getCurrentUser(): User
    {
        $token = $this->getUserToken();

        return $token->getUser();
    }

    public function getCurrentUserRoles(): array
    {
        $token = $this->getUserToken();

        return $token->getRoleNames();
    }

    public function authenticatedAsAdmin(): bool
    {
        $roles = $this->getCurrentUserRoles();
        if (!in_array(Role::Admin->value, $roles)) {
            return false;
        }

        return true;
    }

    public function authenticatedAsModer(): bool
    {
        $roles = $this->getCurrentUserRoles();
        if (!in_array(Role::Moder->value, $roles)) {
            return false;
        }

        return true;
    }
}
