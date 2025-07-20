<?php

namespace Jetcod\DataTransport\Contracts;

interface ValidatorInterface
{
    /**
     * Validate the given value.
     *
     * @param mixed $value
     */
    public function validate($value): bool;

    /**
     * Get the validation error.
     */
    public function getError(): string;
}
