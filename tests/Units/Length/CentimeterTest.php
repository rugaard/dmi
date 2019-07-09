<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Units\Length;

use Rugaard\DMI\DTO\Units\Length\Centimeter;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class CentimeterTest.
 *
 * @package Rugaard\DMI\Tests\Units\Length
 */
class CentimeterTest extends AbstractTestCase
{
    /**
     * Test name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate unit.
        $unit = new Centimeter;

        // Assertions.
        $this->assertIsString($unit->getName());
        $this->assertEquals('Centimeter', $unit->getName());
    }

    /**
     * Test abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate unit.
        $unit = new Centimeter;

        // Assertions.
        $this->assertIsString($unit->getAbbreviation());
        $this->assertEquals('cm', $unit->getAbbreviation());
    }

    /**
     * Test __toString().
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate unit.
        $unit = new Centimeter;

        // Assertions.
        $this->assertIsString((string) $unit);
        $this->assertEquals('cm', (string) $unit);
    }
}