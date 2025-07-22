<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class FloatValidatorTest extends TestCase
{
    public function testValidFloatPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $dto->price = 99.99;

        $this->assertSame(99.99, $dto->price);
    }

    public function testIntegerValueFailsValidation()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type float.');

        $dto->price = 42;
    }

    public function testStringFloatFailsValidation()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type float.');

        $dto->price = "123.45"; // string, not float
    }

    public function testStringNonNumericFailsValidation()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type float.');

        $dto->price = "not a number";
    }

    public function testBooleanFailsValidation()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type float.');

        $dto->price = true;
    }

    public function testNullFailsValidation()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type float.');

        $dto->price = null;
    }

    public function testNegativeFloatPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'float']);

        $dto->price = -123.456;

        $this->assertSame(-123.456, $dto->price);
    }
}
