<?php

namespace Jetcod\DataTransport\Test;

use Jetcod\DataTransport\AbstractDTO;
use Jetcod\DataTransport\Test\Stubs\DataTransferObject;

/**
 * @internal
 *
 * @coversNothing
 */
class DataTransferObjectTest extends TestCase
{
    public function testSetAttributes()
    {
        $dto        = $this->makeTestDTO(['name' => $name = $this->faker->name()]);
        $dto->email = $email = $this->faker->email();
        $dto->phone = $phone = $this->faker->phoneNumber;

        $reflectionClass    = new \ReflectionClass(AbstractDTO::class);
        $reflectionProperty = $reflectionClass->getProperty('attributes');
        $reflectionProperty->setAccessible(true);
        $actualValue = $reflectionProperty->getValue($dto);

        $this->assertIsArray($actualValue);
        $this->assertEquals([
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ], $actualValue);
    }

    public function testMakableObject()
    {
        $actualValue = DataTransferObject::make([
            'name'  => $name  = $this->faker->name(),
            'email' => $email = $this->faker->email(),
            'phone' => $phone = $this->faker->phoneNumber,
        ]);

        $this->assertInstanceOf(AbstractDTO::class, $actualValue);
        $this->assertEquals([
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ], $actualValue->toArray());
    }

    public function testSetInvalidDataType()
    {
        $this->expectException(\TypeError::class);

        $this->makeTestDTO('an_string');
    }

    public function testUnsetAttribute()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
        ];

        $dto = $this->makeTestDTO($expectedValues);
        $this->assertEquals(array_keys($expectedValues), array_keys($dto->toArray()));

        unset($dto->email);

        $this->assertEquals(['name', 'phone'], array_keys($dto->toArray()));
    }

    public function testUpdateAttribute()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
        ];

        $dto = $this->makeTestDTO($expectedValues);
        $this->assertEquals($expectedValues, $dto->toArray());

        $dto->email = $expectedValues['email'] = 'another email';
        $this->assertEquals($expectedValues, $dto->toArray());
    }

    public function testGetAttributes()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $dto = $this->makeTestDTO($expectedValues);

        $this->assertEquals($expectedValues, [
            'name'  => $dto->name,
            'email' => $dto->email,
        ]);
    }

    public function testGetNonExistentAttribute()
    {
        $dto       = $this->makeTestDTO();
        $dto->name = $this->faker->name();

        $this->assertEquals(null, $dto->anotherName);
    }

    public function testHasAttribute()
    {
        $expectedValues = [
            'email'      => $this->faker->email(),
            'dob'        => null,
            'registered' => false,
        ];

        $dto = $this->makeTestDTO($expectedValues);

        $this->assertEquals(true, $dto->has('email'));
        $this->assertEquals(true, $dto->has('dob'));
        $this->assertEquals(true, $dto->has('registered'));
        $this->assertEquals(false, $dto->has('phone'));
    }

    public function testIssetAttribute()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $dto = $this->makeTestDTO($expectedValues);

        $this->assertEquals(true, isset($dto->name));
        $this->assertEquals(true, isset($dto->email));
        $this->assertEquals(false, isset($dto->phone));
    }

    public function testToString()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $dto = $this->makeTestDTO($expectedValues);

        $this->assertEquals(json_encode($expectedValues), (string) $dto);
    }

    public function testGetAttributesAsArray()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $dto = $this->makeTestDTO($expectedValues);

        $this->assertEquals($expectedValues, $dto->toArray());
    }

    public function testGetAttributesAsJson()
    {
        $expectedValues = [
            'name'  => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $dto = $this->makeTestDTO($expectedValues);

        $this->assertJson($dto->toJson());
        $this->assertEquals(json_encode($expectedValues), $dto->toJson());
    }

    public function testHookIsCalledOnConstruct()
    {
        $expectedValues = [
            'name'  => $name = $this->faker->name(),
            'email' => $email = $this->faker->email(),
            'init'  => false,
        ];
        $dto = new class($expectedValues) extends DataTransferObject {
            public function init()
            {
                $this->init = true;
            }
        };

        $this->assertTrue($dto->init);
        $this->assertEquals($name, $dto->name);
        $this->assertEquals($email, $dto->email);
    }
}
