<?php

namespace Jetcod\DataTransport\Contracts;

interface SchemaValidatorInterface
{
    /**
     * Validate the schema against the context.
     *
     * @param string $attribute the key to validate
     */
    public function validateAttribute(string $attribute, $value);

    /**
     * Validate data object.
     *
     * @param Arrayable $obj the object to be validated
     */
    public function validate(Arrayable $obj): ValidationResultInterface;
}
