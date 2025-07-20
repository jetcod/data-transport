<?php

namespace Jetcod\DataTransport\Contracts;

interface SchemaValidatorInterface
{
    /**
     * Validate the schema against the context.
     *
     * @param string $attribute the key to validate
     * @param mixed  $value     the value to validate
     */
    public function validateAttribute(string $attribute, $value): void;

    /**
     * Validate the schema against the context.
     *
     * @param array $data the data to validate
     */
    public function validateAttributes(array $data): void;
}
