<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class ArrayValidatorTest extends TestCase
{
    public function testArrayValidationAcceptsArray()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['items' => 'array']);

        $dto->items = ['a', 'b', 'c'];

        $this->assertSame(['a', 'b', 'c'], $dto->items);
    }

    public function testArrayValidationRejectsString()
    {
        $this->expectException(ValidationException::class);

        $dto = new TypedEntityObject();
        $dto->setSchema(['items' => 'array']);

        $dto->items = 'not an array';
    }

    public function testArrayValidationRejectsInteger()
    {
        $this->expectException(ValidationException::class);

        $dto = new TypedEntityObject();
        $dto->setSchema(['items' => 'array']);

        $dto->items = 123;
    }

    public function testArrayValidationRejectsNull()
    {
        $this->expectException(ValidationException::class);

        $dto = new TypedEntityObject();
        $dto->setSchema(['items' => 'array']);

        $dto->items = null;
    }
}
