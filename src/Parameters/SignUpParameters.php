<?php

declare(strict_types=1);

namespace App\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUpParameters
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string', message: 'This value {{ value }} should be of type string.')]
    #[Assert\Length(min: 2, max: 32)]
    public $name;

    #[Assert\NotBlank]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    #[Assert\Length(min: 2, max: 128)]
    public $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 255)]
    public $password;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 255)]
    public $password_confirmation;

    public function __construct($name, $email, $password, $password_confirmation)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }
}
