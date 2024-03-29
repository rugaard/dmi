<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Units\Pressure;

use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class HectopascalTest.
 *
 * @package Rugaard\DMI\Tests\Units\Pressure
 */
class HectopascalTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Hectopascal;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Hectopascal', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Hectopascal;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('hPa', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Hectopascal;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('hPa', (string) $unit);
    }
}