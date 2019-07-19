<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Forecast;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\DTO\Forecast\Hour;
use Rugaard\DMI\DTO\Measurements\Humidity;
use Rugaard\DMI\DTO\Measurements\Precipitation;
use Rugaard\DMI\DTO\Measurements\Pressure;
use Rugaard\DMI\DTO\Measurements\Temperature;
use Rugaard\DMI\DTO\Measurements\Visibility;
use Rugaard\DMI\DTO\Measurements\Wind;
use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class HourTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Forecast
 */
class HourTest extends AbstractTestCase
{
    /**
     * Mocked test data.
     *
     * @var array|null
     */
    protected $mockedData;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Mocked test data.
        $this->mockedData = json_decode(file_get_contents(__DIR__ . '/../../Support/MockedResponses/JSON/Location.json'), true)['timeserie'][0];

        parent::setUp();
    }

    /**
     * Test set/get temperature.
     *
     * @return void
     */
    public function testTemperature() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set temperature.
        $dto->setTemperature(new Temperature($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Temperature::class, $dto->getTemperature());
        $this->assertIsFloat($dto->getTemperature()->getValue());
        $this->assertEquals(23.197327, $dto->getTemperature()->getValue());
        $this->assertIsFloat($dto->getTemperature()->getLowestValue());
        $this->assertEquals(22.539215, $dto->getTemperature()->getLowestValue());
        $this->assertIsFloat($dto->getTemperature()->getHighestValue());
        $this->assertEquals(24.579132, $dto->getTemperature()->getHighestValue());
        $this->assertInstanceOf(Celsius::class, $dto->getTemperature()->getUnit());
    }

    /**
     * Test set/get wind.
     *
     * @return void
     */
    public function testWind() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set wind.
        $dto->setWind(new Wind($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Wind::class, $dto->getWind());
        $this->assertIsFloat($dto->getWind()->getSpeed()->getValue());
        $this->assertEquals(2.9302678, $dto->getWind()->getSpeed()->getValue());
        $this->assertIsFloat($dto->getWind()->getSpeed()->getLowestValue());
        $this->assertEquals(2.1742203, $dto->getWind()->getSpeed()->getLowestValue());
        $this->assertIsFloat($dto->getWind()->getSpeed()->getHighestValue());
        $this->assertEquals(3.372418, $dto->getWind()->getSpeed()->getHighestValue());
        $this->assertInstanceOf(MetersPerSecond::class, $dto->getWind()->getSpeed()->getUnit());
    }

    /**
     * Test set/get humidity.
     *
     * @return void
     */
    public function testHumidity() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set humidity.
        $dto->setHumidity(new Humidity($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Humidity::class, $dto->getHumidity());
        $this->assertIsFloat($dto->getHumidity()->getValue());
        $this->assertEquals(52.539135, $dto->getHumidity()->getValue());
        $this->assertInstanceOf(Percentage::class, $dto->getHumidity()->getUnit());
    }

    /**
     * Test set/get pressure.
     *
     * @return void
     */
    public function testPressure() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set pressure.
        $dto->setPressure(new Pressure($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Pressure::class, $dto->getPressure());
        $this->assertIsFloat($dto->getPressure()->getValue());
        $this->assertEquals(1010.11127, $dto->getPressure()->getValue());
        $this->assertInstanceOf(Hectopascal::class, $dto->getPressure()->getUnit());
    }

    /**
     * Test set/get precipitation.
     *
     * @return void
     */
    public function testPrecipitation() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set precipitation.
        $dto->setPrecipitation(new Precipitation($this->mockedData));
        $this->assertIsFloat($dto->getPrecipitation()->getValue());
        $this->assertEquals(0.0, $dto->getPrecipitation()->getValue());
        $this->assertIsFloat($dto->getPrecipitation()->getLowestValue());
        $this->assertEquals(0.0, $dto->getPrecipitation()->getLowestValue());
        $this->assertIsFloat($dto->getPrecipitation()->getHighestValue());
        $this->assertEquals(0.0, $dto->getPrecipitation()->getHighestValue());
        $this->assertInstanceOf(Millimeter::class, $dto->getPrecipitation()->getUnit());

        // Assertions.
        $this->assertInstanceOf(Precipitation::class, $dto->getPrecipitation());
    }

    /**
     * Test set/get visibility.
     *
     * @return void
     */
    public function testVisibility() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set visibility.
        $dto->setVisibility(new Visibility($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Visibility::class, $dto->getVisibility());
        $this->assertIsFloat($dto->getVisibility()->getValue());
        $this->assertEquals(41843.824, $dto->getVisibility()->getValue());
        $this->assertInstanceOf(Meter::class, $dto->getVisibility()->getUnit());
    }

    /**
     * Test set/get timestamp.
     *
     * @return void
     */
    public function testTimestamp() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set timestamp.
        $dto->setTimestamp($this->mockedData['time'], new DateTimeZone('Europe/Copenhagen'));

        // Assertions.
        $this->assertInstanceOf(DateTime::class, $dto->getTimestamp());
        $this->assertEquals('2019-06-30 09:00:00', $dto->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test set/get warnings.
     *
     * @return void
     */
    public function testWarnings() : void
    {
        // Instantiate empty DTO.
        $dto = new Hour;

        // Set warnings.
        $dto->setWarnings(Collection::make());

        // Assertions.
        $this->assertInstanceOf(Collection::class, $dto->getWarnings());
    }
}