<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class User
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'string', length: 32)]
    #[Assert\NotBlank()]
    private $name;

    #[ORM\Column(type: 'string', length: 128, unique: true)]
    #[Assert\NotBlank()]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private $password;

    #[ORM\Column(type: 'string', length: 16)]
    #[Assert\NotBlank()]
    private $role;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
