<?php

namespace Jetcod\DataTransport\Validations;

use Jetcod\DataTransport\Contracts\SchemaValidatorInterface;
use Jetcod\DataTransport\Contracts\ValidatorInterface;
use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Helpers\Str;

class SchemaValidator implements SchemaValidatorInterface
{
    private bool $strict;

    private array $schema;

    private array $errors = [];

    public function __construct(array $schema, bool $strict = true)
    {
        $this->schema = $schema;
        $this->strict = $strict;
    }

    /**
     * Validate the schema against the context.
     *
     * @param string $attribute the key to validate
     * @param mixed  $value     the value to validate
     */
    public function validateAttribute(string $attribute, $value): void
    {
        if (!array_key_exists($attribute, $this->schema)) {
            return;
        }

        try {
            $validator = $this->initializeValidator($this->schema[$attribute]);
        } catch (\InvalidArgumentException $e) {
            if ($this->strict) {
                throw $e;
            }

            return;
        }

        if (!$validator->validate($value)) {
            $this->errors[$attribute] = $validator->getError();

            throw new ValidationException($this->errors);
        }
    }

    /**
     * Validate the attributes against the schema.
     */
    public function validateAttributes(array $data): void
    {
        foreach ($data as $attribute => $value) {
            try {
                $this->validateAttribute($attribute, $value);
            } catch (ValidationException $e) {
                $this->errors[$attribute] = $e->getMessage();
            }
        }

        if ($this->hasError()) {
            throw new ValidationException($this->errors);
        }
    }

    /**
     * Get the validation errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if the schema has errors.
     */
    public function hasError(): bool
    {
        return count($this->errors) > 0;
    }

    private function initializeValidator(string $type): ValidatorInterface
    {
        $validatorClass = $this->getValidatorName($type);

        if (!$validatorClass) {
            throw new \InvalidArgumentException("Validator for type {$type} not found.");
        }

        return new $validatorClass();
    }

    private function getValidatorName(string $type): ?string
    {
        $validatorNamespace = __NAMESPACE__ . '\Validators\\' . Str::studly($type) . 'Validator';

        return class_exists($validatorNamespace) ? $validatorNamespace : null;
    }
}
