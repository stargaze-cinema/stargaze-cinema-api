<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProducerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProducerRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class Producer
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank()]
    private $name;

    #[ORM\OneToMany(mappedBy: 'producer', targetEntity: Movie::class)]
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getName(): ?string
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
            // set the owning side to null (unless already changed)
            if ($movie->getProducer() === $this) {
                $movie->setProducer(null);
            }
        }

        return $this;
    }
}
