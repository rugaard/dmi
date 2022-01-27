<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Units\Length;

use Rugaard\DMI\Old\DTO\Units\Length\Millimeter;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class MillimeterTest.
 *
 * @package Rugaard\DMI\Old\Tests\Units\Length
 */
class MillimeterTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Millimeter;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Millimeter', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Millimeter;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('mm', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Millimeter;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('mm', (string) $unit);
    }
}
