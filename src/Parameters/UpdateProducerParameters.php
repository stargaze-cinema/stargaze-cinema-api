<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateProducerParameters
{
    public function __construct(
        #[Assert\Type(type: 'string')]
        #[Assert\Length(min: 2, max: 64)]
        private $name
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
}
