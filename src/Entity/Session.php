<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class Session
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank()]
    private $begin_time;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank()]
    private $end_time;

    #[ORM\ManyToOne(targetEntity: Movie::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $movie;

    #[ORM\ManyToOne(targetEntity: Hall::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $hall;

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

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }
}
