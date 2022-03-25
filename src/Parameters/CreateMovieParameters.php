<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateMovieParameters
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 64)]
        private $title,
        #[Assert\Length(max: 65535)]
        #[Assert\Type(type: 'string')]
        private $description,
        #[Assert\Length(max: 255)]
        #[Assert\Type(type: 'string')]
        private $poster,
        #[Assert\NotBlank]
        #[Assert\Type(type: ['integer', 'float'])]
        #[Assert\Positive]
        private $price,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        #[Assert\Positive]
        #[Assert\GreaterThanOrEqual(value: 1888)]
        private $year,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        #[Assert\GreaterThanOrEqual(value: 30)]
        private $duration,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $category_id,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $producer_id
    ) {
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string
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
    public function getDescription(): string | null
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
    public function getPoster(): string | null
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
    public function getPrice(): float | int
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
    public function getYear(): int
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
    public function getDuration(): int
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
     * Get the value of category_id
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     */
    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of producer_id
     */
    public function getProducerId(): int
    {
        return $this->producer_id;
    }

    /**
     * Set the value of producer_id
     */
    public function setProducerId(int $producer_id): self
    {
        $this->producer_id = $producer_id;

        return $this;
    }
}
