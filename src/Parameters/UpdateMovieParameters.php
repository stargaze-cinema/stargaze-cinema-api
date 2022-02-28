<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateMovieParameters
{
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    #[Assert\Length(min: 2, max: 64)]
    public $title;

    #[Assert\Length(max: 65535)]
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    public $description;

    #[Assert\Length(max: 255)]
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    #[Assert\Url]
    public $poster;

    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual(value: 1888)]
    public $year;

    #[Assert\Type(type: 'float', message: 'This value {{ value }} should be of type float.')]
    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual(value: 10)]
    public $price;

    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\GreaterThanOrEqual(value: 30)]
    public $duration;

    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    public $category;

    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    public $producer;

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
}
