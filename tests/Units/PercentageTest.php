<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Units;

use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class PercentageTest.
 *
 * @package Rugaard\DMI\Tests\Units
 */
class PercentageTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Percentage;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Percentage', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Percentage;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('%', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Percentage;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('%', (string) $unit);
    }
}