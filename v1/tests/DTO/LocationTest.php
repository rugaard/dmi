<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\Old\DTO\Forecast\Current;
use Rugaard\DMI\Old\DTO\Forecast\Day;
use Rugaard\DMI\Old\DTO\Forecast\Hour;
use Rugaard\DMI\Old\DTO\Location;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class LocationTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO
 */
class LocationTest extends AbstractTestCase
{
    /**
     * Test set/get id.
     *
     * @return void
     */
    public function testId() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked ID.
        $mockedId = 12345678;

        // Set ID.
        $dto->setId($mockedId);

        // Assertions.
        $this->assertIsInt($dto->getId());
        $this->assertEquals($mockedId, $dto->getId());
    }

    /**
     * Test set/get city.
     *
     * @return void
     */
    public function testCity() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked city.
        $mockedCity = 'Mocked city';

        // Set city.
        $dto->setCity($mockedCity);

        // Assertions.
        $this->assertIsString($dto->getCity());
        $this->assertEquals($mockedCity, $dto->getCity());
    }

    /**
     * Test set/get country.
     *
     * @return void
     */
    public function testCountry() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked country.
        $mockedCountry = 'DK';

        // Set country.
        $dto->setCountry($mockedCountry);

        // Assertions.
        $this->assertIsString($dto->getCountry());
        $this->assertEquals($mockedCountry, $dto->getCountry());
    }

    /**
     * Test set/get latitude.
     *
     * @return void
     */
    public function testLatitude() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked latitude.
        $mockedLatitude = 12.3456789;

        // Set latitude.
        $dto->setLatitude($mockedLatitude);

        // Assertions.
        $this->assertIsFloat($dto->getLatitude());
        $this->assertEquals($mockedLatitude, $dto->getLatitude());
    }

    /**
     * Test set/get latitude.
     *
     * @return void
     */
    public function testLongitude() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked longitude.
        $mockedLongitude = -12.3456789;

        // Set longitude.
        $dto->setLongitude($mockedLongitude);

        // Assertions.
        $this->assertIsFloat($dto->getLongitude());
        $this->assertEquals($mockedLongitude, $dto->getLongitude());
    }

    /**
     * Test set/get last update.
     *
     * @return void
     */
    public function testLastUpdate() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked timestamp.
        $mockedTimestamp = '2019-06-30 22:22:22';

        // Set last update.
        $dto->setLastUpdate(
            str_replace([' ', '-', ':'], '', $mockedTimestamp),
            new DateTimeZone('Europe/Copenhagen')
        );

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getLastUpdate());
        $this->assertEquals($mockedTimestamp, $dto->getLastUpdate()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getLastUpdate()->getTimezone()->getName());
    }

    /**
     * Test set/get sunrise.
     *
     * @return void
     */
    public function testSunrise() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked timestamp.
        $mockedTimestamp = date('Y-m-d') . ' 04:28:00';

        // Set sunrise.
        $dto->setSunrise(DateTime::createFromFormat('Y-m-d H:i:s', $mockedTimestamp)->format('Gi'), new DateTimeZone('Europe/Copenhagen'));

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getSunrise());
        $this->assertEquals($mockedTimestamp, $dto->getSunrise()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getSunrise()->getTimezone()->getName());
    }

    /**
     * Test set/get sunset.
     *
     * @return void
     */
    public function testSunset() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked timestamp.
        $mockedTimestamp = date('Y-m-d') . ' 21:58:00';

        // Set sunrise.
        $dto->setSunset(DateTime::createFromFormat('Y-m-d H:i:s', $mockedTimestamp)->format('Gi'), new DateTimeZone('Europe/Copenhagen'));

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getSunset());
        $this->assertEquals($mockedTimestamp, $dto->getSunset()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getSunset()->getTimezone()->getName());
    }

    /**
     * Test get forecast.
     *
     * @return void
     */
    public function testForecast() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Assertions.
        $this->assertInstanceOf(Collection::class, $dto->getForecasts());
    }

    /**
     * Test set/get currently forecast.
     *
     * @return void
     */
    public function testCurrentlyForecast() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked data.
        $mockedData = json_decode(file_get_contents(__DIR__ . '/../Support/MockedResponses/JSON/Location.json'), true)['timeserie'][0];

        // Set currently forecast.
        $dto->setCurrentlyForecast($mockedData, new DateTimeZone('Europe/Copenhagen'));

        // Assertions.
        $this->assertInstanceOf(Current::class, $dto->getCurrentlyForecast());
    }

    /**
     * Test set/get hourly forecast.
     *
     * @return void
     */
    public function testHourlyForecast() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked data.
        $mockedData = json_decode(file_get_contents(__DIR__ . '/../Support/MockedResponses/JSON/Location.json'), true)['timeserie'];

        // Set hourly forecast.
        $dto->setHourlyForecast($mockedData, new DateTimeZone('Europe/Copenhagen'));

        // Assertions.
        $this->assertInstanceOf(Collection::class, $dto->getHourlyForecast());
        $this->assertCount(96, $dto->getHourlyForecast());
        $this->assertTrue($dto->getHourlyForecast()->has('20190630090000'));
        $this->assertInstanceOf(Hour::class, $dto->getHourlyForecast()->first());
    }

    /**
     * Test set/get daily forecast.
     *
     * @return void
     */
    public function testDailyForecast() : void
    {
        // Instantiate empty DTO.
        $dto = new Location;

        // Mocked test data.
        $mockedData = json_decode(file_get_contents(__DIR__ . '/../Support/MockedResponses/JSON/Location.json'), true)['timeserie'];

        // Set daily forecast.
        $dto->setDailyForecast($mockedData, new DateTimeZone('Europe/Copenhagen'));

        // Assertions.
        $this->assertInstanceOf(Collection::class, $dto->getDailyForecast());
        $this->assertCount(11, $dto->getDailyForecast());
        $this->assertTrue($dto->getDailyForecast()->has('20190630'));
        $this->assertInstanceOf(Day::class, $dto->getDailyForecast()->first());
    }
}
