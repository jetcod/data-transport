<?php

namespace Jetcod\DataTransport\Test\Stubs;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class CustomValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return false;
    }

    public function getError(): string
    {
        return 'custom validation message';
    }

    public function alias(): string
    {
        return 'custom';
    }
}