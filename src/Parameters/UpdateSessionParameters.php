<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateSessionParameters
{
    public function __construct(
        #[Assert\Regex(
            pattern: '/(\d\d\d\d)(-)?(\d\d)(-)?(\d\d)(T)?(\d\d)(:)?(\d\d)(:)?(\d\d)(\.\d+)?(Z|([+-])(\d\d)(:)?(\d\d))/',
            message: 'This value {{ value }} is not a valid DateTime, expected ISO string.'
        )]
        private \DateTime | string | null $beginAt,
        #[Assert\Regex(
            pattern: '/(\d\d\d\d)(-)?(\d\d)(-)?(\d\d)(T)?(\d\d)(:)?(\d\d)(:)?(\d\d)(\.\d+)?(Z|([+-])(\d\d)(:)?(\d\d))/',
            message: 'This value {{ value }} is not a valid DateTime, expected ISO string.'
        )]
        private \DateTime | string | null $endAt,
        #[Assert\Type(type: 'integer')]
        private $movieId,
        #[Assert\Type(type: 'integer')]
        private $hallId
    ) {
    }

    /**
     * Get the value of beginAt
     */
    public function getBeginAt(): \DateTime | string | null
    {
        return $this->beginAt;
    }

    /**
     * Set the value of beginAt
     */
    public function setBeginAt(\DateTime $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    /**
     * Get the value of endAt
     */
    public function getEndAt(): \DateTime | string | null
    {
        return $this->endAt;
    }

    /**
     * Set the value of endAt
     */
    public function setEndAt(\DateTime $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get the value of movieId
     */
    public function getMovieId(): ?int
    {
        return $this->movieId;
    }

    /**
     * Set the value of movieId
     */
    public function setMovieId(int $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
    }

    /**
     * Get the value of hallId
     */
    public function getHallId(): ?int
    {
        return $this->hallId;
    }

    /**
     * Set the value of hallId
     */
    public function setHallId(int $hallId): self
    {
        $this->hallId = $hallId;

        return $this;
    }
}
