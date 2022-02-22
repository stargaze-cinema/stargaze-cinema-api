<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HallRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HallRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class Hall
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'string', length: 16)]
    #[Assert\NotBlank()]
    private $name;

    #[ORM\Column(type: 'smallint')]
    #[Assert\NotBlank()]
    private $capacity;

    #[ORM\Column(type: 'string', length: 8)]
    #[Assert\NotBlank()]
    private $type;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
