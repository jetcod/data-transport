<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class StringValidationTest extends TestCase
{
    public function testValidPlainStringPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['name' => 'string']);

        $dto->name = 'John Doe';

        $this->assertSame('John Doe', $dto->name);
    }

    public function testEmptyStringPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['comment' => 'string']);

        $dto->comment = '';

        $this->assertSame('', $dto->comment);
    }

    public function testMultibyteFarsiStringPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['text' => 'string']);

        $dto->text = 'سلام دنیا'; // Farsi: "Hello world"

        $this->assertSame('سلام دنیا', $dto->text);
    }

    public function testIntegerThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['name' => 'string']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a string.');

        $dto->name = 12345;
    }

    public function testBooleanThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['name' => 'string']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a string.');

        $dto->name = true;
    }

    public function testArrayThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['name' => 'string']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a string.');

        $dto->name = ['John'];
    }

    public function testObjectThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['name' => 'string']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a string.');

        $dto->name = new \stdClass();
    }

    public function testNullThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['name' => 'string']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be a string.');

        $dto->name = null;
    }
}
