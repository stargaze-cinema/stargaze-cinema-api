<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateTicketParameters
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $place,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $userId,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $sessionId
    ) {
    }

    /**
     * Get the value of place
     */
    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * Set the value of place
     */
    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of sessionId
     */
    public function getSessionId(): int
    {
        return $this->sessionId;
    }

    /**
     * Set the value of sessionId
     */
    public function setSessionId(int $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }
}
