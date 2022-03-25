<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateUserParameters
{
    public function __construct(
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 32)]
        private $name,
        #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
        #[Assert\Length(min: 2, max: 128)]
        private $email,
        #[Assert\Type(type: 'array')]
        #[Assert\Length(min: 8, max: 255)]
        private $roles,
        #[Assert\NotBlank]
        #[Assert\Length(min: 8, max: 255)]
        private $password,
        #[Assert\NotBlank]
        #[Assert\Length(min: 8, max: 255)]
        private $password_confirmation
    ) {
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password_confirmation
     *
     * @return string
     */
    public function getPassword_confirmation(): string
    {
        return $this->password_confirmation;
    }

    /**
     * Set the value of password_confirmation
     *
     * @param string $password_confirmation
     * @return self
     */
    public function setPassword_confirmation(string $password_confirmation): self
    {
        $this->password_confirmation = $password_confirmation;

        return $this;
    }
}
