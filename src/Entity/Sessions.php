<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SessionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionsRepository::class)]
#[ApiResource]
class Sessions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: Movies::class, cascade: ['persist', 'remove'])]
    private $movie_id;

    #[ORM\OneToOne(targetEntity: Halls::class, cascade: ['persist', 'remove'])]
    private $hall_id;

    #[ORM\Column(type: 'datetime')]
    private $begin_time;

    #[ORM\Column(type: 'datetime')]
    private $end_time;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieId(): ?Movies
    {
        return $this->movie_id;
    }

    public function setMovieId(?Movies $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getHallId(): ?Halls
    {
        return $this->hall_id;
    }

    public function setHallId(?Halls $hall_id): self
    {
        $this->hall_id = $hall_id;

        return $this;
    }

    public function getBeginTime(): ?\DateTimeInterface
    {
        return $this->begin_time;
    }

    public function setBeginTime(\DateTimeInterface $begin_time): self
    {
        $this->begin_time = $begin_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

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
