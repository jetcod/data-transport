<?php

namespace Jetcod\DataTransport\Validations;

use Jetcod\DataTransport\Contracts\Arrayable;
use Jetcod\DataTransport\Contracts\SchemaValidatorInterface;
use Jetcod\DataTransport\Contracts\ValidationResultInterface;
use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Validations\Resolver as ValidatorResolver;

class DataValidator implements SchemaValidatorInterface
{
    private bool $strict;

    private array $schema;

    private Result $result;

    private ValidatorResolver $resolver;

    public function __construct(array $schema, bool $strict)
    {
        $this->schema = $schema;
        $this->strict = $strict;
        $this->result = new Result();
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
     * Validate multiple attributes.
     */
    public function validate(Arrayable $obj): ValidationResultInterface
    {
        $data   = $obj->toArray();
        $result = $this->getValidationResult();

        foreach ($data as $attribute => $value) {
            try {
                $this->validateAttribute($attribute, $value);
            } catch (ValidationException $e) {
                $result->addError($attribute, $e->getMessage());
            }
        }

        return $result;
    }

    /**
     * Validate a single attribute against its corresponding validator.
     *
     * @param string $attribute the key to validate
     */
    public function validateAttribute(string $attribute, $value)
    {
        if (!array_key_exists($attribute, $this->schema)) {
            return;
        }

        try {
            $resolver = $this->getResolver()->resolve($this->schema[$attribute]);
        } catch (\RuntimeException $e) {
            if ($this->strict) {
                throw $e;
            }

            return;
        }

        if (!$resolver->validate($value)) {
            throw new ValidationException($resolver->getError());
        }
    }

    private function getValidationResult(): ValidationResultInterface
    {
        return $this->result;
    }
}
