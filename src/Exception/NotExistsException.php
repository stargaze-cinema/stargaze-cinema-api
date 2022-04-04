<?php

declare(strict_types=1);

namespace App\Exception;

final class NotExistsException extends \DomainException
{
    protected $message;

    public function __construct(string $message)
    {
        $this->_defaultCode = 401;
        $this->message = $message;
        parent::__construct();
    }
}
