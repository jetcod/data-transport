<?php

namespace Jetcod\DataTransport\Test;

use Jetcod\DataTransport\Contracts\TypedEntity;
use Jetcod\DataTransport\Exceptions\ValidationException;
use Jetcod\DataTransport\Test\Stubs\TypedEntityObject;
use Jetcod\DataTransport\Test\Stubs\DataTransferObject;

class DataValidationTest extends TestCase
{
    public function testInvalidStringThrowaValidationException()
    {
        $dto = new TypedEntityObject();
        $dto->setSchema(['email' => 'string']);

        $this->expectExceptionObject(new ValidationException([
            'email' => 'The value must be a string.'
        ]));

        $dto->email = rand(1, 1000);
    }

    public function testConstructWithInvalidDataThrowaValidationException()
    {
        $data = [
            'id'  => $this->faker->name(),
            'email' => rand(1, 1000),
        ];

        $exception = new ValidationException([
            'id' => 'The value must be an integer.',
            'email' => 'The value must be a string.'
        ]);
        $this->expectExceptionObject($exception);

        new class($data) extends DataTransferObject implements TypedEntity {
            public function getSchema(): array
            {
                return [
                    'id'  => 'int',
                    'email' => 'string',
                ];
            }
        };
    }

    public function testIgnoreValidationOfNonTypedEntitiesDataObjects()
    {
        $data = [
            'id'    => $randName = $this->faker->name(),
            'email' => $randValue = rand(1, 1000),
        ];

        $dto = new class($data) extends DataTransferObject {
            public function getSchema(): array
            {
                return [
                    'id'    => 'int',
                    'email' => 'string',
                ];
            }
        };

        $this->assertEquals($randValue, $dto->email);
        $this->assertEquals($randName, $dto->id);
    }

    public function testUndefinedValidatorThrowsExceptionOnStrictMode()
    {
        $data = [
            'address'  => 'the address goes here'
        ];

        $exception = new \RuntimeException('No validator found for alias: custom');
        $this->expectExceptionObject($exception);

        new class($data, false, true) extends DataTransferObject implements TypedEntity {
            public function getSchema(): array
            {
                return [
                    'address' => 'custom',
                ];
            }
        };
    }

    public function testUndefinedValidatorPassesValidationOnNoneStrictMode()
    {
        $data = [
            'address'  => 'the address goes here'
        ];
        
        $dto = new class($data, false, false) extends DataTransferObject implements TypedEntity {
            public function getSchema(): array
            {
                return [
                    'address' => 'custom',
                ];
            }
        };

        $this->assertEquals('the address goes here', $dto->address);
    }

    public function testIgnoreValidationOnNonExistentValidationKey()
    {
        $dto = new TypedEntityObject([]);
        $dto->setSchema(['id' => 'int']);

        $dto->email = 'info@example.com';

        $this->assertEquals('info@example.com', $dto->email);
    }
}
