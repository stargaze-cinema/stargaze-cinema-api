<?php

namespace App\Entity;

use App\Repository\FrameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FrameRepository::class)]
#[ORM\Table(name: "frames")]
#[ORM\HasLifecycleCallbacks()]
class Frame extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $image;

    #[ORM\ManyToOne(targetEntity: Movie::class, inversedBy: 'frames')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Movie $movie;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function jsonSerialize(): array
    {
        $movie = $this->getMovie();
        return [
            'id' => $this->id,
            'image' => $this->image,
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
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
