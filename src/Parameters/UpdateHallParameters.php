<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateHallParameters
{
    public function __construct(
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 16)]
        private $name,
        #[Assert\Type(type: 'integer')]
        private $capacity,
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 8)]
        private $type,
    ) {
    }

    /**
      * Get the value of name
      */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of capacity
     */
    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    /**
     * Set the value of capacity
     */
    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
