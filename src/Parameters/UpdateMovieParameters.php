<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateMovieParameters
{
    public function __construct(
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 64)]
        private $title,
        #[Assert\Length(max: 65535)]
        #[Assert\Type(type: 'string')]
        private $description,
        #[Assert\Length(max: 255)]
        #[Assert\Type(type: 'string')]
        private $poster,
        #[Assert\Type(type: ['integer', 'float'])]
        private $price,
        #[Assert\Type(type: 'integer')]
        private $year,
        #[Assert\Type(type: 'integer')]
        private $duration,
        #[Assert\Type(type: 'integer')]
        private $categoryId,
        #[Assert\Type(type: 'integer')]
        private $producerId
    ) {
    }

    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of poster
     */
    public function getPoster(): ?string
    {
        return $this->poster;
    }

    /**
     * Set the value of poster
     */
    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice(): float | int | null
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice(float | int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of year
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * Set the value of year
     */
    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of duration
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of categoryId
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * Set the value of categoryId
     */
    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get the value of producerId
     */
    public function getProducerId(): ?int
    {
        return $this->producerId;
    }

    /**
     * Set the value of producerId
     */
    public function setProducerId(int $producerId): self
    {
        $this->producerId = $producerId;

        return $this;
    }
}
