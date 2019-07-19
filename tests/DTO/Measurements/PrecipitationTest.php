<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Precipitation;
use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class PrecipitationTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurements
 */
class PrecipitationTest extends AbstractTestCase
{
    /**
     * Test set/get type.
     *
     * @return void
     */
    public function testType() : void
    {
        // Supported precipitation types.
        $precipitationTypes = Collection::make(['rain', 'hail', 'sleet', 'snow']);

        $precipitationTypes->each(function ($precipitationType) {
            // Instantiate empty DTO.
            $dto = new Precipitation;

            // Set precipitation type.
            $dto->setType($precipitationType);

            // Assertions.
            $this->assertIsString($dto->getType());
            $this->assertEquals($precipitationType, $dto->getType());
        });
    }

    /**
     * Test set/get type by danish key.
     *
     * @return void
     */
    public function testTypeByDanishKey() : void
    {
        // Supported precipitation types.
        $precipitationTypes = Collection::make([
            'regn' => 'rain',
            'hagl' => 'hail',
            'slud' => 'sleet',
            'sne' => 'snow'
        ]);

        $precipitationTypes->each(function ($precipitationType, $danishPrecipitationType) {
            // Instantiate empty DTO.
            $dto = new Precipitation;

            // Set precipitation type.
            $dto->setTypeByDanishKey($danishPrecipitationType);

            // Assertions.
            $this->assertIsString($dto->getType());
            $this->assertEquals($precipitationType, $dto->getType());
        });

        // Test unsupported precipitation type.
        $dto = new Precipitation;

        // Set unsupported precipitation type.
        $dto->setTypeByDanishKey('glitter');

        // Assertions.
        $this->assertNull($dto->getType());
    }

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