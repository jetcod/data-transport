<?php

namespace Jetcod\DataTransport\Validations;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class Resolver
{
    protected string $directory;
    protected string $namespace;

    public function __construct(
        string $directory = __DIR__ . '/Validators',
        string $namespace = 'Jetcod\DataTransport\Validators'
    ) {
        $this->directory = $directory;
        $this->namespace = rtrim($namespace, '\\');
    }

    public function resolve($alias): ValidatorInterface
    {
        if ($alias instanceof ValidatorInterface) {
            return $alias;
        }

        if (!is_string($alias)) {
            throw new \InvalidArgumentException(sprintf(
                'Validator must be a string alias or an instance of %s.',
                ValidatorInterface::class
            ));
        }

        if (class_exists($alias)) {
            return $this->instantiateValidatorClass($alias);
        }

        // Try resolving alias via scanning registered validator classes
        foreach ($this->getValidatorClasses() as $class) {
            if (!class_exists($class)) {
                continue;
            }

            $reflection = new \ReflectionClass($class);

            if (!$reflection->isInstantiable() || !$reflection->implementsInterface(ValidatorInterface::class)) {
                continue;
            }

            /** @var ValidatorInterface $instance */
            $instance = $reflection->newInstance();

            if ($instance->alias() === $alias) {
                return $instance;
            }
        }

        throw new \RuntimeException("No validator found for alias: {$alias}");
    }

    /**
     * Safely instantiate a validator class if valid.
     */
    protected function instantiateValidatorClass(string $class): ValidatorInterface
    {
        $reflection = new \ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new \RuntimeException("Validator class {$class} is not instantiable.");
        }

        if (!$reflection->implementsInterface(ValidatorInterface::class)) {
            throw new \RuntimeException("Validator class {$class} must implement " . ValidatorInterface::class);
        }

        return $reflection->newInstance();
    }

    /**
     * Discover all fully-qualified class names in the validators directory.
     *
     * @return string[]
     */
    protected function getValidatorClasses(): array
    {
        $files   = glob($this->directory . '/*.php');
        $classes = [];

        foreach ($files as $file) {
            $className = basename($file, '.php');
            $classes[] = $this->namespace . '\\' . $className;
        }

        return $classes;
    }
}
