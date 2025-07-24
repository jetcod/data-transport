<?php

namespace Jetcod\DataTransport\Validations\Validators;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class IntValidator implements ValidatorInterface
{
    /**
     * Validate if the value is a integer.
     */
    public function validate($value): bool
    {
        return is_integer($value);
    }

    /**
     * Get the error message for validation failure.
     */
    public function getError(): string
    {
        return 'The value must be an integer.';
    }

    public function alias(): string
    {
        return 'int';
    }
}
