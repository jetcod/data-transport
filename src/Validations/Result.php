<?php

namespace Jetcod\DataTransport\Validations;

use Jetcod\DataTransport\Contracts\ValidationResultInterface;

class Result implements ValidationResultInterface
{
    private array $errors = [];

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute] = $message;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return empty($this->errors());
    }
}
