<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Units\Speed;

use Rugaard\DMI\Old\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class MetersPerSecondTest.
 *
 * @package Rugaard\DMI\Old\Tests\Units\Speed
 */
class MetersPerSecondTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new MetersPerSecond;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Meters per second', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new MetersPerSecond;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('m/s', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new MetersPerSecond;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('m/s', (string) $unit);
    }
}
