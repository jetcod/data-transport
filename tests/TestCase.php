<?php

namespace Jetcod\DataTransport\Test;

use Faker\Factory as Faker;
use Jetcod\DataTransport\Test\Stubs\DataTransferObject;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class TestCase extends PHPUnitTestCase
{
    /**
     * @var Faker
     */
    protected $faker;

    protected function setUp(): void
    {
        $this->faker = Faker::create();
    }

    protected function makeTestDTO($data = null)
    {
        return new DataTransferObject($data);
    }
}
