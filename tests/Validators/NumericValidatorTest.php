<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class NumericValidatorTest extends TestCase
{
    public function testNumericValidationAcceptsInteger()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $dto->price = 100;

        $this->assertSame(100, $dto->price);
    }

    public function testNumericValidationAcceptsFloat()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $dto->price = 99.99;

        $this->assertSame(99.99, $dto->price);
    }

    public function testNumericValidationAcceptsStringNumber()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);
        $dto->price = '123.45';

        $this->assertSame('123.45', $dto->price);
    }

    public function testNumericValidationRejectsNonNumericString()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a number.');

        $dto->price = 'not-a-number';
    }

    public function testNumericValidationRejectsBoolean()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a number.');

        $dto->price = true;
    }

    public function testNumericValidationRejectsNull()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a number.');

        $dto->price = null;
    }

    public function testNumericValidationRejectsArray()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a number.');

        $dto->price = [1, 2, 3];
    }

    public function testNumericValidationRejectsObject()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a number.');

        $dto->price = new \stdClass();
    }

    public function testNumericValidationAcceptsNegativeNumbers()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $dto->price = -42.5;

        $this->assertSame(-42.5, $dto->price);
    }

    public function testNumericValidationAcceptsZero()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['price' => 'numeric']);

        $dto->price = 0;

        $this->assertSame(0, $dto->price);
    }
}
