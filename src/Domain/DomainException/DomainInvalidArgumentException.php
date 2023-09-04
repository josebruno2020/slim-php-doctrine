<?php

namespace App\Domain\DomainException;

class DomainInvalidArgumentException extends DomainException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message);
    }
}