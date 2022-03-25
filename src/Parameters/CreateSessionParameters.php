<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateSessionParameters
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/(\d\d\d\d)(-)?(\d\d)(-)?(\d\d)(T)?(\d\d)(:)?(\d\d)(:)?(\d\d)(\.\d+)?(Z|([+-])(\d\d)(:)?(\d\d))/',
            message: 'This value {{ value }} is not a valid DateTime, expected ISO string.'
        )]
        private \DateTime | string $begin_at,
        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/(\d\d\d\d)(-)?(\d\d)(-)?(\d\d)(T)?(\d\d)(:)?(\d\d)(:)?(\d\d)(\.\d+)?(Z|([+-])(\d\d)(:)?(\d\d))/',
            message: 'This value {{ value }} is not a valid DateTime, expected ISO string.'
        )]
        private \DateTime | string $end_at,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $movie_id,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $hall_id
    ) {
    }

    /**
     * Get the value of begin_at
     */
    public function getBeginTime(): \DateTime | string
    {
        return $this->begin_at;
    }

    /**
     * Set the value of begin_at
     */
    public function setBeginTime(\DateTime $begin_at): self
    {
        $this->begin_at = $begin_at;

        return $this;
    }

    /**
     * Get the value of end_at
     */
    public function getEndTime(): \DateTime | string
    {
        return $this->end_at;
    }

    /**
     * Set the value of end_at
     */
    public function setEndTime(\DateTime $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }

    /**
     * Get the value of movie_id
     */
    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    /**
     * Set the value of movie_id
     */
    public function setMovieId(int $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    /**
     * Get the value of hall_id
     */
    public function getHallId(): int
    {
        return $this->hall_id;
    }

    /**
     * Set the value of hall_id
     */
    public function setHallId(int $hall_id): self
    {
        $this->hall_id = $hall_id;

        return $this;
    }
}
