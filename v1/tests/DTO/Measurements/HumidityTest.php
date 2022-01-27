<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO\Measurements;

use Rugaard\DMI\Old\DTO\Measurements\Humidity;
use Rugaard\DMI\Old\Units\Length\Millimeter;
use Rugaard\DMI\Old\Units\Percentage;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class HumidityTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO\Measurements
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
