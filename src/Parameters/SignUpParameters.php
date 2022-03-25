<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUpParameters
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 32)]
        private $name,
        #[Assert\NotBlank]
        #[Assert\Email]
        #[Assert\Length(min: 2, max: 128)]
        private $email,
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
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password_confirmation
     */
    public function getPassword_confirmation(): string
    {
        return $this->password_confirmation;
    }

    /**
     * Set the value of password_confirmation
     */
    public function setPassword_confirmation(string $password_confirmation): self
    {
        $this->password_confirmation = $password_confirmation;

        return $this;
    }
}
