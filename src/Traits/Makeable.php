<?php

namespace Jetcod\DataTransport\Traits;

trait Makeable
{
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
}
