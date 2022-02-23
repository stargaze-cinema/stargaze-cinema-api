<?php

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateMovieParameters
{
    #[Assert\NotBlank]
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

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\Positive]
    public $price;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual(value: 1888)]
    public $year;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'This value {{ value }} should be of type integer.')]
    #[Assert\GreaterThanOrEqual(value: 30)]
    public $duration;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    public $category;

    #[Assert\NotBlank]
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
