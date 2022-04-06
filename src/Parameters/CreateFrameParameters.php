<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateFrameParameters
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $movieId,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Assert\Type(type: 'string')]
        private $image
    ) {
    }

    /**
     * Get the value of movieId
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * Get the value of image
     */
    public function getImage(): string
    {
        return $this->image;
    }
}
