<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait EntityTimestampsTrait
{
    #[ORM\Column(type: "datetime", nullable: true)]
    private \DateTime $created_at;

    #[ORM\Column(type: "datetime", nullable: true)]
    private \DateTime $updated_at;

    #[ORM\PrePersist()]
    public function createdAt(): void
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    #[ORM\PreUpdate()]
    public function updatedAt(): void
    {
        $this->updated_at = new \DateTime();
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(int $place): self
    {
        $this->place = $place;

        return $this;
    }
}
