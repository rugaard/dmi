<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Temperature;
use Rugaard\DMI\Units\Bearing;
use Rugaard\DMI\Units\Temperature\Celsius;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class TemperatureTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurement
 */
class TemperatureTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Temperature;

        // Mocked value.
        $mockedValue = 14.501837;

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
        $dto = new Temperature;

        // Mocked lowest value.
        $mockedLowestValue = -8.027431;

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
        $dto = new Temperature;

        // Mocked highest value.
        $mockedHighestValue = 32.871025;

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
        $dto = new Temperature;

        // Assert default unit.
        $this->assertInstanceOf(Celsius::class, $dto->getUnit());

        // Set unit
        $dto->setUnit(new Bearing);

        // Assertions.
        $this->assertInstanceOf(Bearing::class, $dto->getUnit());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Temperature;

        // Mocked value.
        $mockedValue = 26.761302;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('26°C', (string) $dto);
    }
}
