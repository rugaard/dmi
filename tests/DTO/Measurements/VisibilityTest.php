<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Visibility;
use Rugaard\DMI\Units\Length\Centimeter;
use Rugaard\DMI\Units\Length\Meter;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class VisibilityTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurements
 */
class VisibilityTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Visibility;

        // Mocked value.
        $mockedValue = 49281.76;

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
        $dto = new Visibility;

        // Assert default unit.
        $this->assertInstanceOf(Meter::class, $dto->getUnit());

        // Set unit
        $dto->setUnit(new Centimeter);

        // Assertions.
        $this->assertInstanceOf(Centimeter::class, $dto->getUnit());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Visibility;

        // Mocked value.
        $mockedValue = 26182.091356;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('26182 m', (string) $dto);
    }
}
