<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Pressure;
use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class PressureTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurements
 */
class PressureTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Pressure;

        // Mocked value.
        $mockedValue = 1018.641305;

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
        $dto = new Pressure;

        // Assert default unit.
        $this->assertInstanceOf(Hectopascal::class, $dto->getUnit());

        // Set unit
        $dto->setUnit(new Percentage);

        // Assertions.
        $this->assertInstanceOf(Percentage::class, $dto->getUnit());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Pressure;

        // Mocked value.
        $mockedValue = 981.073571;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('981 hPa', (string) $dto);
    }
}