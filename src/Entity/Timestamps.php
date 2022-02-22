<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait Timestamps
{
    #[ORM\Column(type: "datetime", nullable: true)]
    private $created_at;

    #[ORM\Column(type: "datetime", nullable: true)]
    private $updated_at;

    #[ORM\PrePersist()]
    public function createdAt()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    #[ORM\PreUpdate()]
    public function updatedAt()
    {
        $this->updated_at = new \DateTime();
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(int $place): self
    {
        $this->place = $place;

        return $this;
    }
}
