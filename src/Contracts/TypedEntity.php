<?php

namespace Jetcod\DataTransport\Contracts;

interface TypedEntity
{
    /**
     * Returns an array representing the schema that defines the types associated with each attribute.
     */
    public function getSchema(): array;

    public function validate(): ValidationResultInterface;

    public function validateAttribute(string $attribute, $value);

    public function getValidator(): SchemaValidatorInterface;
}
