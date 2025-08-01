<?php

namespace Jetcod\DataTransport\Contracts;

interface ValidationResultInterface
{
    public function addError(string $attribute, string $message);

    public function isValid(): bool;

    public function errors(): array;
}
