<?php

namespace Jetcod\DataTransport;

use Jetcod\DataTransport\Contracts\Arrayable;
use Jetcod\DataTransport\Contracts\Jsonable;
use Jetcod\DataTransport\Contracts\SchemaValidatorInterface;
use Jetcod\DataTransport\Contracts\TypedEntity;
use Jetcod\DataTransport\Traits\Makeable;
use Jetcod\DataTransport\Validations\DataValidator;

abstract class AbstractDTO implements Arrayable, Jsonable
{
    use Makeable;

    /**
     * An array of object attributes.
     *
     * @var array
     */
    private $attributes = [];

    private $_strict = true;

    final public function __construct(?array $attributes = null, bool $strict = true)
    {
        $this->attributes = $attributes ?? [];
        $this->_strict    = $strict;

        if (method_exists($this, 'init')) {
            $this->init();
        }

        $this->validateAttributes($this->toArray());
    }

    /**
     * Set a value.
     *
     * @param mixed $val
     */
    public function __set(string $key, $val)
    {
        $this->validateAttributes([$key => $val]);

        $this->attributes[$key] = $val;
    }

    /**
     * Get an attribute value.
     */
    public function __get(string $key)
    {
        return $this->has($key) ? $this->attributes[$key] : null;
    }

    /**
     * Determine whether the ke is set.
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }

    /**
     * Unset a key.
     */
    public function __unset(string $key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Convert data to a json string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Determine if the key has been set.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Check if the DTO is in strict mode.
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

    /**
     * Return data as array.
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Return data as json.
     */
    public function toJson(int $options = 0): string
    {
        $json = json_encode($this->attributes, $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(json_last_error_msg());
        }

        return $json;
    }

    /**
     * Creates and returns a schema validator for the current DTO instance.
     */
    protected function getValidator(): SchemaValidatorInterface
    {
        if (!method_exists($this, 'getSchema')) {
            throw new \RuntimeException(sprintf('The method %s::getSchema() is not defined.', static::class));
        }

        return new DataValidator($this->getSchema(), $this->_strict);
    }

    /**
     * Validate data using the schema validator.
     */
    private function validateAttributes(array $attributes): void
    {
        if (!$this instanceof TypedEntity) {
            return;
        }

        $this->getValidator()->validateAttributes($attributes);
    }
}
