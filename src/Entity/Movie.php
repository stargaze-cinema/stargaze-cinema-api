<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: "movies")]
#[ORM\HasLifecycleCallbacks()]
class Movie implements \JsonSerializable
{
    use Id;
    use Timestamps;

    #[ORM\Column(type: 'string', length: 64)]
    private $title;

    #[ORM\Column(type: 'string', length: 65535, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $poster;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'smallint')]
    private $year;

    #[ORM\Column(type: 'smallint')]
    private $duration;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\ManyToOne(targetEntity: Producer::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
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

    public function setPoster(?string $poster): self
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

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'poster' => $this->poster,
            'price' => $this->price,
            'year' => $this->year,
            'duration' => $this->duration,
            'category' => [
                'id' => $this->category->getId(),
                'name' => $this->category->getName(),
            ],
            'producer' => [
                'id' => $this->producer->getId(),
                'name' => $this->producer->getName(),
            ],
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
