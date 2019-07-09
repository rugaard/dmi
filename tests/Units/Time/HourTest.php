<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Units\Time;

use Rugaard\DMI\DTO\Units\Time\Hour;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class HourTest.
 *
 * @package Rugaard\DMI\Tests\Units\Time
 */

class HourTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Hour;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Hour', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Hour;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('h', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Hour;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('h', (string) $unit);
    }
}