<?php

namespace Jetcod\DataTransport\Validations\Validators;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class BooleanValidator implements ValidatorInterface
{
    /**
     * Validate if the value is a string.
     *
     * @param mixed $value
     */
    public function validate($value): bool
    {
        return is_bool($value);
    }

    /**
     * Get the error message for validation failure.
     */
    public function getError(): string
    {
        return 'The value must be of type boolean.';
    }

    public function alias(): string
    {
        return 'boolean';
    }
}
