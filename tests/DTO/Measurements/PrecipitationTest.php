<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Precipitation;
use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class PrecipitationTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurements
 */
class PrecipitationTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Precipitation;

        // Mocked value.
        $mockedValue = 8.791586;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsFloat($dto->getValue());
        $this->assertEquals($mockedValue, $dto->getValue());
    }

    /**
     * Test set/get lowest value.
     *
     * @return void
     */
    public function testLowestValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Precipitation;

        // Mocked lowest value.
        $mockedLowestValue = 0.129753;

        // Set lowest value.
        $dto->setLowestValue($mockedLowestValue);

        // Assertions.
        $this->assertIsFloat($dto->getLowestValue());
        $this->assertEquals($mockedLowestValue, $dto->getLowestValue());
    }

    /**
     * Test set/get highest value.
     *
     * @return void
     */
    public function testHighestValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Precipitation;

        // Mocked highest value.
        $mockedHighestValue = 11.021749;

        // Set highest value.
        $dto->setHighestValue($mockedHighestValue);

        // Assertions.
        $this->assertIsFloat($dto->getHighestValue());
        $this->assertEquals($mockedHighestValue, $dto->getHighestValue());
    }

    /**
     * Test set/get unit.
     *
     * @return void
     */
    public function testUnit() : void
    {
        // Instantiate empty DTO.
        $dto = new Precipitation;

        // Assert default unit.
        $this->assertInstanceOf(Millimeter::class, $dto->getUnit());

        // Set unit
        $dto->setUnit(new Meter);

        // Assertions.
        $this->assertInstanceOf(Meter::class, $dto->getUnit());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Precipitation;

        // Mocked value.
        $mockedValue = 4.351792;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('4.4 mm', (string) $dto);
    }
}