<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class IntValidatorTest extends TestCase
{
    public function testIntegerValidationAcceptsValidInteger()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $dto->age = $num = $this->faker->numberBetween(1, 100);

        $this->assertSame($num, $dto->age);
    }

    public function testIntegerValidationRejectsStringifiedInteger()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be an integer.');

        $dto->age = '42';
    }

    public function testIntegerValidationRejectsFloat()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be an integer.');

        $dto->age = $this->faker->randomFloat(1, 1, 100);
    }

    public function testIntegerValidationRejectsNull()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be an integer.');

        $dto->age = null;
    }

    public function testIntegerValidationRejectsBoolean()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be an integer.');

        $dto->age = true;
    }

    public function testIntegerValidationRejectsArray()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be an integer.');

        $dto->age = [42];
    }

    public function testIntegerValidationRejectsObject()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be an integer.');

        $dto->age = new \stdClass();
    }

    public function testIntegerValidationAcceptsNegativeInteger()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $dto->age = -100;

        $this->assertSame(-100, $dto->age);
    }

    public function testIntegerValidationAcceptsZero()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['age' => 'int']);

        $dto->age = 0;

        $this->assertSame(0, $dto->age);
    }
}