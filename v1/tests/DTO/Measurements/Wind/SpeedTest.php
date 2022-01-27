<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO\Measurements\Wind;

use Rugaard\DMI\Old\DTO\Measurements\Wind\Speed;
use Rugaard\DMI\Old\Units\Length\Meter;
use Rugaard\DMI\Old\Units\Speed\MetersPerSecond;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class SpeedTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO\Measurements\Wind
 */
class SpeedTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Speed;

        // Mocked value.
        $mockedValue = 8.695341;

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
        $dto = new Speed;

        // Mocked lowest value.
        $mockedLowestValue = 1.216407;

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
        $dto = new Speed;

        // Mocked highest value.
        $mockedHighestValue = 13.031640;

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
        $dto = new Speed;

        // Assert default unit.
        $this->assertInstanceOf(MetersPerSecond::class, $dto->getUnit());

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
        $dto = new Speed;

        // Mocked value.
        $mockedValue = 6.410732;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('6.4 m/s', (string) $dto);
    }
}
