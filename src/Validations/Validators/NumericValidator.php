<?php

namespace Jetcod\DataTransport\Validations\Validators;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class NumericValidator implements ValidatorInterface
{
    /**
     * Validate if the value is a string.
     *
     * @param mixed $value
     */
    public function validate($value): bool
    {
        return is_numeric($value);
    }

    /**
     * Get the error message for validation failure.
     */
    public function getError(): string
    {
        return 'The value must be of type float.';
    }

    public function alias(): string
    {
        return 'numeric';
    }
}
