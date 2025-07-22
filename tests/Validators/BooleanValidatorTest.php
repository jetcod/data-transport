<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class BooleanValidatorTest extends TestCase
{
    public function testBooleanValidationAcceptsTrue()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $dto->active = true;

        $this->assertTrue($dto->active);
    }

    public function testBooleanValidationAcceptsFalse()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $dto->active = false;

        $this->assertFalse($dto->active);
    }

    public function testBooleanValidationRejectsString()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type boolean.');

        $dto->active = 'true';
    }

    public function testBooleanValidationRejectsInteger()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type boolean.');

        $dto->active = 1;
    }

    public function testBooleanValidationRejectsFloat()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type boolean.');

        $dto->active = 0.0;
    }

    public function testBooleanValidationRejectsNull()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type boolean.');

        $dto->active = null;
    }

    public function testBooleanValidationRejectsArray()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type boolean.');

        $dto->active = [true];
    }

    public function testBooleanValidationRejectsObject()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type boolean.');

        $dto->active = new \stdClass();
    }

    public function testBooleanValidationAcceptsDefaultFalse()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['active' => 'bool']);

        $this->assertNull($dto->active ?? null);
    }
}
