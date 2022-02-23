<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\Table(name: "sessions")]
#[ORM\HasLifecycleCallbacks()]
class Session implements \JsonSerializable
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'datetime')]
    private $begin_time;

    #[ORM\Column(type: 'datetime')]
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

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'movie' => [
                'id' => $this->movie->getId(),
                'title' => $this->movie->title,
                'description' => $this->movie->description,
                'poster' => $this->movie->poster,
                'price' => $this->movie->price,
                'year' => $this->movie->year,
                'duration' => $this->movie->duration,
            ],
            'hall' => [
                'id' => $this->hall->getId(),
                'name' => $this->hall->name,
                'capacity' => $this->hall->capacity,
                'type' => $this->hall->type
            ],
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
