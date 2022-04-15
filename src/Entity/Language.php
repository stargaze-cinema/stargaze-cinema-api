<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
#[ORM\Table(name: 'languages'), ORM\HasLifecycleCallbacks]
class Language extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 64)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: Movie::class)]
    private Collection $movies;

    #[ORM\Column(type: 'string', length: 2)]
    private string $code;

    #[ORM\Column(type: 'string', length: 64)]
    private string $native_name;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNativeName(): string
    {
        return $this->native_name;
    }

    public function setNativeName(string $native_name): self
    {
        $this->native_name = $native_name;

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
            $movie->setLanguage($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            if ($movie->getLanguage() === $this) {
                $movie->setLanguage(null);
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
                    'synopsis' => $movie->getSynopsis(),
                    'poster' => $movie->getPoster(),
                    'price' => $movie->getPrice(),
                    'year' => $movie->getYear(),
                    'runtime' => $movie->getRuntime(),
                    'rating' => $movie->getRating(),
                    'language' => [
                        'id' => $movie->getLanguage()->getId(),
                        'name' => $movie->getLanguage()->getName(),
                        'created_at' => $movie->getLanguage()->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                        'updated_at' => $movie->getLanguage()->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                    ],
                    'countries' => $movie->getCountries()->map(function (Country $country) {
                        return [
                            'id' => $country->getId(),
                            'name' => $country->getName(),
                            'created_at' => $country->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                            'updated_at' => $country->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                        ];
                    })->toArray(),
                    'genres' => $movie->getGenres()->map(function (Genre $genre) {
                        return [
                            'id' => $genre->getId(),
                            'name' => $genre->getName(),
                            'created_at' => $genre->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                            'updated_at' => $genre->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                        ];
                    })->toArray(),
                    'directors' => $movie->getDirectors()->map(function (Director $director) {
                        return [
                            'id' => $director->getId(),
                            'name' => $director->getName(),
                            'created_at' => $director->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                            'updated_at' => $director->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                        ];
                    })->toArray(),
                    'sessions' => $movie->getSessions()->map(function (Session $session) {
                        return [
                            'id' => $session->getId(),
                            'begin_at' => $session->getBeginAt()->format('Y-m-d\TH:i:s.u'),
                            'end_at' => $session->getEndAt()->format('Y-m-d\TH:i:s.u'),
                            'hall' => [
                                'id' => $session->getHall()->getId(),
                                'name' => $session->getHall()->getName(),
                                'capacity' => $session->getHall()->getCapacity(),
                                'type' => $session->getHall()->getType(),
                                'created_at' => $session->getHall()->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                                'updated_at' => $session->getHall()->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                            ],
                            'created_at' => $session->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                            'updated_at' => $session->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                            'deleted_at' => $session->getDeletedAt()?->format('Y-m-d\TH:i:s.u'),
                        ];
                    })->toArray(),
                    'frames' => $movie->getFrames()->map(function (Frame $frame) {
                        return [
                            'id' => $frame->getId(),
                            'image' => $frame->getImage(),
                            'created_at' => $frame->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                            'updated_at' => $frame->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                        ];
                    })->toArray(),
                    'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
                ];
            })->toArray(),
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}