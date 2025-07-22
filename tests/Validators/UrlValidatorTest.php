<?php

namespace Jetcod\DataTransport\Test\Validators;

use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\TestCase;

class UrlValidatorTest extends TestCase
{
    public function testValidHttpUrlPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $dto->website = 'http://example.com';

        $this->assertSame('http://example.com', $dto->website);
    }

    public function testValidHttpsUrlPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $dto->website = 'https://example.com/path?query=123';

        $this->assertSame('https://example.com/path?query=123', $dto->website);
    }

    public function testValidFtpUrlPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $dto->website = 'ftp://ftp.example.com';

        $this->assertSame('ftp://ftp.example.com', $dto->website);
    }

    public function testInvalidUrlThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = 'not-a-valid-url';
    }

    public function testMissingSchemeThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = 'www.example.com';
    }

    public function testEmptyStringThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = '';
    }

    public function testIntegerThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = 12345;
    }

    public function testArrayThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = ['http://example.com'];
    }

    public function testBooleanThrowsValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = true;
    }

    public function testUrlWithPortPasses()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $dto->website = 'https://example.com:8080';

        $this->assertSame('https://example.com:8080', $dto->website);
    }

    public function testUrlWithUserAndPasswordFails()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['website' => 'url']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The value is not a valid URL.');

        $dto->website = 'https://user:pass@example.com';
    }
}
