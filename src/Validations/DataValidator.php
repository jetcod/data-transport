<?php

namespace Jetcod\DataTransport\Validations;

use Jetcod\DataTransport\Contracts\SchemaValidatorInterface;
use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Validations\Resolver as ValidatorResolver;

class DataValidator implements SchemaValidatorInterface
{
    private bool $strict;

    private array $schema;

    private array $errors = [];

    private ValidatorResolver $resolver;

    public function __construct(array $schema, bool $strict = true)
    {
        $this->schema = $schema;
        $this->strict = $strict;
    }

    /**
     * Set the validator resolver.
     */
    public function setResolver(ValidatorResolver $resolver): self
    {
        $this->resolver = $resolver;

        return $this;
    }

    /**
     * Get the validator resolver.
     */
    public function getResolver(): ValidatorResolver
    {
        if (!isset($this->resolver)) {
            $this->resolver = new ValidatorResolver(__DIR__ . '/Validators', __NAMESPACE__ . '\Validators');
        }

        return $this->resolver;
    }

    /**
     * Validate a single attribute against its corresponding validator.
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
            $validator = $this->getResolver()->resolve($this->schema[$attribute]);
        } catch (\RuntimeException $e) {
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
     * Validate multiple attributes.
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
     * Check if any validation errors exist.
     */
    public function hasError(): bool
    {
        return !empty($this->errors);
    }
}
