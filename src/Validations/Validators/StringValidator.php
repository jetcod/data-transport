<?php

namespace Jetcod\DataTransport\Validations\Validators;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class StringValidator implements ValidatorInterface
{
    /**
     * Validate if the value is a string.
     */
    public function validate($value): bool
    {
        return is_string($value);
    }

    /**
     * Get the error message for validation failure.
     */
    public function getError(): string
    {
        return 'The value must be a string.';
    }

    public function alias(): string
    {
        return 'string';
    }
}
