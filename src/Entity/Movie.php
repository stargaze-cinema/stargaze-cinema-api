<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class Movie
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank()]
    private $title;

    #[ORM\Column(type: 'string', length: 65535, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $poster;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank()]
    private $price;

    #[ORM\Column(type: 'smallint')]
    #[Assert\NotBlank()]
    private $year;

    #[ORM\Column(type: 'smallint')]
    #[Assert\NotBlank()]
    private $duration;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private $category;

    #[ORM\ManyToOne(targetEntity: Producer::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private $producer;

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

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    public function setProducer(?Producer $producer): self
    {
        $this->producer = $producer;

        return $this;
    }
}
