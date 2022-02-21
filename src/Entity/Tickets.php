<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TicketsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketsRepository::class)]
#[ApiResource]
class Tickets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'tickets')]
    private $user;

    #[ORM\OneToOne(targetEntity: Sessions::class, cascade: ['persist', 'remove'])]
    private $session;

    #[ORM\Column(type: 'smallint')]
    private $place;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->user;
    }

    public function setUserId(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSessionId(): ?Sessions
    {
        return $this->session;
    }

    public function setSessionId(?Sessions $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
