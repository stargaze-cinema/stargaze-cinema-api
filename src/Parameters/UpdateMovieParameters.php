<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateMovieParameters
{
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    #[Assert\Length(min: 2, max: 64)]
    private $title;

    #[Assert\Length(max: 65535)]
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    private $description;

    #[Assert\Length(max: 255)]
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    #[Assert\Url]
    private $poster;

    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual(value: 1888)]
    private $year;

    #[Assert\Type(type: ['integer', 'float'], message: 'This value {{ value }} should be of type float.')]
    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual(value: 10)]
    private $price;

    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\GreaterThanOrEqual(value: 30)]
    private $duration;

    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    private $category;

    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    private $producer;

    public function __construct($title, $description, $poster, $price, $year, $duration, $category, $producer)
    {
        $this->title = $title;
        $this->description = $description;
        $this->poster = $poster;
        $this->price = $price;
        $this->title = $title;
        $this->year = $year;
        $this->duration = $duration;
        $this->category = $category;
        $this->producer = $producer;
    }

    /**
     * Get the value of title
     *
     * @return string | null
     */
    public function getTitle(): string | null
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return string | null
     */
    public function getDescription(): string | null
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of poster
     *
     * @return string | null
     */
    public function getPoster(): string | null
    {
        return $this->poster;
    }

    /**
     * Set the value of poster
     *
     * @param string $poster
     * @return self
     */
    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get the value of price
     *
     * @return float | int | null
     */
    public function getPrice(): float | int | null
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param float | int $price
     * @return self
     */
    public function setPrice(float | int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of year
     *
     * @return int | null
     */
    public function getYear(): int | null
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @param int $year
     * @return self
     */
    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of duration
     *
     * @return int | null
     */
    public function getDuration(): int | null
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @param int $duration
     * @return self
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return string | null
     */
    public function getCategory(): string | null
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param string $category
     * @return self
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of producer
     *
     * @return string | null
     */
    public function getProducer(): string | null
    {
        return $this->producer;
    }

    /**
     * Set the value of producer
     *
     * @param string $producer
     * @return self
     */
    public function setProducer(string $producer): self
    {
        $this->producer = $producer;

        return $this;
    }
}
