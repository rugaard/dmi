<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Units\Length;

use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class MeterTest.
 *
 * @package Rugaard\DMI\Tests\Units\Length
 */
class MeterTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Meter;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Meter', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Meter;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('m', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Meter;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('m', (string) $unit);
    }
}