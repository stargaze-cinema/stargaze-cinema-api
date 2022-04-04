<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: \App\Repository\MovieRepository::class)]
#[Gedmo\SoftDeleteable]
#[ORM\Table(name: "movies")]
#[ORM\HasLifecycleCallbacks()]
class Movie extends AbstractEntity
{
    use SoftDeleteableEntity;

    #[ORM\Column(type: 'string', length: 64)]
    private string $title;

    #[ORM\Column(type: 'string', length: 65535, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $poster;

    #[ORM\Column(type: 'decimal')]
    private float $price;

    #[ORM\Column(type: 'smallint')]
    private int $year;

    #[ORM\Column(type: 'smallint')]
    private int $duration;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\ManyToOne(targetEntity: Producer::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private Producer $producer;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Session::class)]
    private Collection $sessions;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Frame::class)]
    private Collection $frames;

    public function __construct()
    {
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->frames = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getTitle(): string
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getProducer(): Producer
    {
        return $this->producer;
    }

    public function setProducer(?Producer $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    /**
      * @return Collection<int, Session>
      */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->session[] = $session;
            $session->setMovie($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->removeElement($session)) {
            if ($session->getMovie() === $this) {
                $session->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Frame>
     */
    public function getFrames(): Collection
    {
        return $this->frames;
    }

    public function addFrame(Frame $frame): self
    {
        if (!$this->frames->contains($frame)) {
            $this->frames[] = $frame;
            $frame->setMovie($this);
        }

        return $this;
    }

    public function removeFrame(Frame $frame): self
    {
        if ($this->frames->removeElement($frame)) {
            if ($frame->getMovie() === $this) {
                $frame->setMovie(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
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
                'created_at' => $this->category->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => $this->category->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
            ],
            'producer' => [
                'id' => $this->producer->getId(),
                'name' => $this->producer->getName(),
                'created_at' => $this->producer->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => $this->producer->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
            ],
            'sessions' => $this->sessions->map(function (Session $session) {
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
                    'deleted_at' => $session->getDeletedAt()?->format('Y-m-d\TH:i:s.u')
                ];
            })->toArray(),
            'frames' => $this->frames->map(function (Frame $frame) {
                return [
                    'id' => $frame->getId(),
                    'image' => $frame->getImage(),
                    'created_at' => $frame->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $frame->getUpdatedAt()->format('Y-m-d\TH:i:s.u')
                ];
            })->toArray(),
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
