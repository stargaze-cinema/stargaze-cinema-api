<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: \App\Repository\SessionRepository::class)]
#[Gedmo\SoftDeleteable]
#[ORM\Table(name: "sessions")]
#[ORM\HasLifecycleCallbacks()]
class Session extends AbstractEntity
{
    use SoftDeleteableEntity;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $begin_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $end_at;

    #[ORM\ManyToOne(targetEntity: Movie::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private Movie $movie;

    #[ORM\ManyToOne(targetEntity: Hall::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Hall $hall;

    public function getBeginAt(): \DateTime
    {
        return $this->begin_at;
    }

    public function setBeginAt(\DateTime $begin_at): self
    {
        $this->begin_at = $begin_at;

        return $this;
    }

    public function getEndAt(): \DateTime
    {
        return $this->end_at;
    }

    public function setEndAt(\DateTime $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getHall(): Hall
    {
        return $this->hall;
    }

    public function setHall(Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $movie = $this->getMovie();
        return [
            'id' => $this->id,
            'begin_at' => $this->begin_at->format('Y-m-d\TH:i:s.u'),
            'end_at' => $this->end_at->format('Y-m-d\TH:i:s.u'),
            'movie' => [
                'id' => $movie->getId(),
                'title' => $movie->getTitle(),
                'description' => $movie->getDescription(),
                'poster' => $movie->getPoster(),
                'price' => $movie->getPrice(),
                'year' => $movie->getYear(),
                'duration' => $movie->getDuration(),
                'category' => [
                    'id' => $movie->getCategory()->getId(),
                    'name' => $movie->getCategory()->getName(),
                    'created_at' => $movie->getCategory()->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $movie->getCategory()->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                ],
                'producer' => [
                    'id' => $movie->getProducer()->getId(),
                    'name' => $movie->getProducer()->getName(),
                    'created_at' => $movie->getProducer()->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $movie->getProducer()->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                ],
                'created_at' => $movie->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => $movie->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
            ],
            'hall' => [
                'id' => $this->hall->getId(),
                'name' => $this->hall->getName(),
                'capacity' => $this->hall->getCapacity(),
                'type' => $this->hall->getType(),
                'created_at' => $this->hall->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => $this->hall->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
            ],
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
