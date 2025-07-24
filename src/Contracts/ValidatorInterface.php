<?php

namespace Jetcod\DataTransport\Contracts;

interface ValidatorInterface
{
    /**
     * Validate the given value.
     */
    public function validate($value): bool;

    /**
     * Get the validation error.
     */
    public function getError(): string;

    /**
     * Get the validation alias.
     */
    public function alias(): string;
}
