<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\ProducerRepository::class)]
#[ORM\Table(name: "producers")]
#[ORM\HasLifecycleCallbacks()]
class Producer extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 64)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'producer', targetEntity: Movie::class)]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setProducer($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            if ($movie->getProducer() === $this) {
                $movie->setProducer(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'movies' => $this->movies->map(function (Movie $movie) {
                return [
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
                    'created_at' => $movie->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $movie->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                ];
            })->toArray(),
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
