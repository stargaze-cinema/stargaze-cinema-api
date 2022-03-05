<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class SignInParameters
{
    #[Assert\NotBlank]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    #[Assert\Length(min: 2, max: 128)]
    public $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 255)]
    public $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
