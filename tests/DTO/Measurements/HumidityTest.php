<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Humidity;
use Rugaard\DMI\Units\Length\Millimeter;
use Rugaard\DMI\Units\Percentage;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class HumidityTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurement
 */
class HumidityTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Humidity;

        // Mocked value.
        $mockedValue = 82.602451;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsFloat($dto->getValue());
        $this->assertEquals($mockedValue, $dto->getValue());
    }

    /**
     * Test set/get unit.
     *
     * @return void
     */
    public function testUnit() : void
    {
        // Instantiate empty DTO.
        $dto = new Humidity;

        // Assert default unit.
        $this->assertInstanceOf(Percentage::class, $dto->getUnit());

        // Set unit
        $dto->setUnit(new Millimeter);

        // Assertions.
        $this->assertInstanceOf(Millimeter::class, $dto->getUnit());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Humidity;

        // Mocked value.
        $mockedValue = 68.714615;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('69%', (string) $dto);
    }
}
