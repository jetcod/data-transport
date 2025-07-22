<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class EmailValidatorTest extends TestCase
{
    public function testEmailValidationAcceptsValidEmail()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $validEmail = $this->faker->email();
        $dto->email = $validEmail;

        $this->assertEquals($validEmail, $dto->email);
    }

    public function testEmailValidationThrowsExceptionOnInvalidEmail()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type email.');

        $dto->email = 'an invalid email';
    }
    
    public function testEmailValidationRejectsNull()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type email.');

        $dto->email = null;
    }
    
    public function testEmailValidationRejectsEmptyString()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type email.');

        $dto->email = '';
    }

    public function testEmailValidationRejectsEmailWithoutDomain()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type email.');

        $dto->email = 'user@';
    }

    public function testEmailValidationRejectsEmailWithSpaces()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type email.');

        $dto->email = ' user@example.com ';
    }

    public function testEmailValidationRejectsUnicodeEmail()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value must be of type email.');

        $dto->email = 'tést@exämple.com';
    }

    public function testEmailFieldIsOptionalWhenNotPresent()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'email']);

        $this->assertNull($dto->email);
    }
}