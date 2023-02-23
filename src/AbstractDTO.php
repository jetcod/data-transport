<?php

namespace Jetcod\DataTransport;

use Jetcod\DataTransport\Contracts\Arrayable;
use Jetcod\DataTransport\Contracts\Jsonable;

abstract class AbstractDTO implements Arrayable, Jsonable
{
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
     * Unset a key.
     *
     * @param int|string $key
     */
    public function __unset($key)
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
     *
     * @param int|string $key
     */
    public function has($key): bool
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
