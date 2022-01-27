<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Units\Temperature;

use Rugaard\DMI\Old\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class CelsiusTest.
 *
 * @package Rugaard\DMI\Old\Tests\Units\Temperature
 */
class CelsiusTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Celsius;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Celsius', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Celsius;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('°C', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Celsius;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('°C', (string) $unit);
    }
}
