<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements\Wind;

use Rugaard\DMI\DTO\Measurements\Wind\Gust;
use Rugaard\DMI\Units\Time\Hour;
use Rugaard\DMI\Units\Speed\MetersPerSecond;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class GustTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurements\Wind
 */
class GustTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Gust;

        // Mocked value.
        $mockedValue = 18.442183;

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
        $dto = new Gust;

        // Assert default unit.
        $this->assertInstanceOf(MetersPerSecond::class, $dto->getUnit());

        // Set unit
        $dto->setUnit(new Hour);

        // Assertions.
        $this->assertInstanceOf(Hour::class, $dto->getUnit());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Gust;

        // Mocked value.
        $mockedValue = 13.961425;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('14.0 m/s', (string) $dto);
    }
}
