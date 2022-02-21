<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
#[ApiResource]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $title;

    #[ORM\Column(type: 'string', length: 65535, nullable: true)]
    private $description;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'integer')]
    private $duration;

    #[ORM\OneToMany(mappedBy: 'movies', targetEntity: Categories::class)]
    private $category_id;

    #[ORM\OneToMany(mappedBy: 'movies', targetEntity: Producers::class)]
    private $producer_id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    public function __construct()
    {
        $this->category_id = new ArrayCollection();
        $this->producer_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategoryId(): Collection
    {
        return $this->category_id;
    }

    public function addCategoryId(Categories $categoryId): self
    {
        if (!$this->category_id->contains($categoryId)) {
            $this->category_id[] = $categoryId;
            $categoryId->setMovies($this);
        }

        return $this;
    }

    public function removeCategoryId(Categories $categoryId): self
    {
        if ($this->category_id->removeElement($categoryId)) {
            // set the owning side to null (unless already changed)
            if ($categoryId->getMovies() === $this) {
                $categoryId->setMovies(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Producers>
     */
    public function getProducerId(): Collection
    {
        return $this->producer_id;
    }

    public function addProducerId(Producers $producerId): self
    {
        if (!$this->producer_id->contains($producerId)) {
            $this->producer_id[] = $producerId;
            $producerId->setMovies($this);
        }

        return $this;
    }

    public function removeProducerId(Producers $producerId): self
    {
        if ($this->producer_id->removeElement($producerId)) {
            // set the owning side to null (unless already changed)
            if ($producerId->getMovies() === $this) {
                $producerId->setMovies(null);
            }
        }

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
