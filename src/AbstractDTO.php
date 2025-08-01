<?php

namespace Jetcod\DataTransport;

use Jetcod\DataTransport\Contracts\Arrayable;
use Jetcod\DataTransport\Contracts\Jsonable;
use Jetcod\DataTransport\Contracts\TypedEntity;
use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Traits\Makeable;

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

    private $_readOnly = false;

    final public function __construct(?array $attributes = null, bool $readOnly = false, bool $strict = false)
    {
        $this->attributes = $attributes ?? [];
        $this->_strict    = $strict;
        $this->_readOnly  = $readOnly;

        if (method_exists($this, 'init')) {
            $this->init();
        }

        if ($this instanceof TypedEntity && $this->isStrict()) {
            $result = $this->validate();
            if (!$result->isValid()) {
                throw new ValidationException($result->errors());
            }
        }
    }

    /**
     * Set a value.
     */
    public function __set(string $key, $val)
    {
        if ($this->isReadOnly()) {
            throw new \Exception('The object is write protected.');
        }

        if ($this instanceof TypedEntity && $this->isStrict()) {
            $this->validateAttribute($key, $val);
        }

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
     * Flag the object as read only.
     */
    public function readOnly(): self
    {
        $this->_readOnly = true;

        return $this;
    }

    /**
     * Check if the object is read only.
     */
    public function isReadOnly(): bool
    {
        return $this->_readOnly;
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
        return $this->_strict;
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
}
