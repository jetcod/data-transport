<?php

namespace Jetcod\DataTransport\Contracts;

interface Jsonable
{
    public function toJson(): string;
}
