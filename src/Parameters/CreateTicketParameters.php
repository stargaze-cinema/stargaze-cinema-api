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
        private $user_id,
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private $session_id
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
     * Get the value of user_id
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId($user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of session_id
     */
    public function getSessionId(): int
    {
        return $this->session_id;
    }

    /**
     * Set the value of session_id
     */
    public function setSessionId(int $session_id): self
    {
        $this->session_id = $session_id;

        return $this;
    }
}
