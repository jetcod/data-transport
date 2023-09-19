<?php

namespace Jetcod\DataTransport;

use Jetcod\DataTransport\Contracts\Arrayable;
use Jetcod\DataTransport\Contracts\Jsonable;
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

    public function __construct(?array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Set a value.
     *
     * @param mixed $val
     */
    public function __set(string $key, $val)
    {
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
        return isset($this->attributes[$key]);
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
