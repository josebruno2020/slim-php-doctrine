<?php

namespace App\Domain\Validation;

use App\Domain\DomainException\DomainInvalidArgumentException;

class DomainValidationHelper
{
    public function validateRequiredArguments(array $arguments, array $data): void
    {
        $keys = array_keys($data);
        foreach ($arguments as $argument) {
            if (!in_array($argument, $keys)) {
                throw new DomainInvalidArgumentException("Campo [$argument] é obrigatório.");
            }
        }
    }
    
    /**
     * @throws DomainInvalidArgumentException
     */
    public static function validateRequiredArgument(mixed $argument, string $argumentName): void
    {
        if (!$argument) {
            throw new DomainInvalidArgumentException($argumentName);
        }
    }
}