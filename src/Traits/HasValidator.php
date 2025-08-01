<?php

namespace Jetcod\DataTransport\Traits;

use Jetcod\DataTransport\Contracts\SchemaValidatorInterface;
use Jetcod\DataTransport\Contracts\ValidationResultInterface;
use Jetcod\DataTransport\Validations\DataValidator;

trait HasValidator
{
    /**
     * Validate the data object.
     */
    public function validate(): ValidationResultInterface
    {
        return $this->getValidator()->validate($this);
    }

    /**
     * Creates and returns a schema validator for the current DTO instance.
     */
    public function getValidator(): SchemaValidatorInterface
    {
        if (!method_exists($this, 'getSchema')) {
            throw new \RuntimeException(sprintf('The method %s::getSchema() is not defined.', static::class));
        }

        return new DataValidator($this->getSchema(), $this->isStrict());
    }

    /**
     * Validate a single attribute.
     *
     * @param mixed $value
     */
    public function validateAttribute(string $attribute, $value)
    {
        return $this->getValidator()->validateAttribute($attribute, $value);
    }
}
