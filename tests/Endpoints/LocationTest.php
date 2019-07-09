<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\DMI;
use Rugaard\DMI\DTO\Forecast\Current;
use Rugaard\DMI\DTO\Forecast\Day;
use Rugaard\DMI\DTO\Forecast\Hour;
use Rugaard\DMI\DTO\Forecast\Text;
use Rugaard\DMI\DTO\Location;
use Rugaard\DMI\DTO\Measurements\Humidity;
use Rugaard\DMI\DTO\Measurements\Precipitation;
use Rugaard\DMI\DTO\Measurements\Pressure;
use Rugaard\DMI\DTO\Measurements\Temperature;
use Rugaard\DMI\DTO\Measurements\Visibility;
use Rugaard\DMI\DTO\Measurements\Wind;
use Rugaard\DMI\DTO\Measurements\Wind\Direction;
use Rugaard\DMI\DTO\Measurements\Wind\Gust;
use Rugaard\DMI\DTO\Measurements\Wind\Speed;
use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class LocationTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class LocationTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Mocked location ID.
     *
     * @var int|null
     */
    protected $mockedLocationId;

    /**
     * Mocked coordinate.
     *
     * @var array
     */
    protected $mockedCoordinate = [];

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Set a mocked location ID.
        $this->mockedLocationId = 2618425;

        // Set mocked coordinate.
        $this->mockedCoordinate = [
            'latitude' => 55.6625,
            'longitude' => 12.5653,
        ];

        parent::setUp();
    }

    /**
     * Test location.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testBasics() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, true,false);

        // Assertions.
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals($this->mockedLocationId, $location->getId());
        $this->assertEquals('København', $location->getCity());
        $this->assertEquals('København', $location->getMunicipality());
        $this->assertEquals('Storkøbenhavn', $location->getRegion());
        $this->assertEquals('DK', $location->getCountry());
        $this->assertIsFloat($location->getLatitude());
        $this->assertEquals(55.67594, $location->getLatitude());
        $this->assertIsFloat($location->getLongitude());
        $this->assertEquals(12.56553, $location->getLongitude());
        $this->assertInstanceOf(DateTime::class, $location->getLastUpdate());
        $this->assertEquals('2019-06-30 09:00:06', $location->getLastUpdate()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $location->getLastUpdate()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $location->getSunrise());
        $this->assertEquals(date('Y-m-d') . ' 04:29:00', $location->getSunrise()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $location->getSunrise()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $location->getSunset());
        $this->assertEquals(date('Y-m-d') . ' 21:56:00', $location->getSunset()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $location->getSunset()->getTimezone()->getName());
        $this->assertInstanceOf(Collection::class, $location->getForecasts());
    }

    /**
     * Test location with "global" location ID.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithGlobalId() : void
    {
        $dmi = new DMI($this->mockedLocationId, $this->mockLocationWithFailedRegional());

        // Get location.
        $location = $dmi->location();

        // Assertions.
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals($this->mockedLocationId, $location->getId());
    }

    /**
     * Test location by coordinate (aka. nearest weather station)
     * and failed regional data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithEmptyRegional() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocationWithEmptyRegional());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, true,false);

        // Assertions.
        $this->assertInstanceOf(Location::class, $location);
        $this->assertNull($location->getMunicipality());
        $this->assertNull($location->getRegion());
        $this->assertNull($location->getRegionalForecast());
    }

    /**
     * Test location by coordinate (aka. nearest weather station).
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithCoordinates() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location by coordinate (aka. nearest weather station).
        $location = $dmi->locationByCoordinate($this->mockedCoordinate['latitude'], $this->mockedCoordinate['longitude']);

        // Assertions.
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals('København', $location->getCity());
        $this->assertEquals('København', $location->getMunicipality());
        $this->assertEquals('Storkøbenhavn', $location->getRegion());
        $this->assertEquals('DK', $location->getCountry());
        $this->assertIsFloat($location->getLatitude());
        $this->assertEquals(55.67594, $location->getLatitude());
        $this->assertIsFloat($location->getLongitude());
        $this->assertEquals(12.56553, $location->getLongitude());
        $this->assertInstanceOf(DateTime::class, $location->getLastUpdate());
        $this->assertEquals('2019-06-30 09:00:06', $location->getLastUpdate()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $location->getLastUpdate()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $location->getSunrise());
        $this->assertEquals(date('Y-m-d') . ' 04:29:00', $location->getSunrise()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $location->getSunrise()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $location->getSunset());
        $this->assertEquals(date('Y-m-d') . ' 21:56:00', $location->getSunset()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $location->getSunset()->getTimezone()->getName());
        $this->assertInstanceOf(Collection::class, $location->getForecasts());
    }

    /**
     * Test location by coordinate (aka. nearest weather station)
     * and failed regional data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithCoordinatesAndFailedRegional() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocationWithFailedRegional());

        // Get location by coordinate (aka. nearest weather station).
        $location = $dmi->locationByCoordinate($this->mockedCoordinate['latitude'], $this->mockedCoordinate['longitude'], true, false);

        // Assertions.
        $this->assertInstanceOf(Location::class, $location);
        $this->assertNull($location->getMunicipality());
        $this->assertNull($location->getRegion());
        $this->assertNull($location->getRegionalForecast());
    }

    /**
     * Test location forecasts.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testForecasts() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, true,false);

        $this->assertInstanceOf(Collection::class, $location->getForecasts());
        $this->assertCount(4, $location->getForecasts());
        $this->assertArrayHasKey('currently', $location->getForecasts()->toArray());
        $this->assertArrayHasKey('hourly', $location->getForecasts()->toArray());
        $this->assertArrayHasKey('daily', $location->getForecasts()->toArray());
        $this->assertArrayHasKey('regional', $location->getForecasts()->toArray());
    }

    /**
     * Test currently forecast for location.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testCurrentlyForecast() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, false,false);

        // Get current forecast.
        $currentForecast = $location->getCurrentlyForecast();
        $this->assertInstanceOf(Current::class, $currentForecast);

        // Temperature.
        $this->assertInstanceOf(Temperature::class, $currentForecast->getTemperature());
        $this->assertIsFloat($currentForecast->getTemperature()->getValue());
        $this->assertEquals(23.197327, $currentForecast->getTemperature()->getValue());
        $this->assertIsFloat($currentForecast->getTemperature()->getLowestValue());
        $this->assertEquals(22.539215, $currentForecast->getTemperature()->getLowestValue());
        $this->assertIsFloat($currentForecast->getTemperature()->getHighestValue());
        $this->assertEquals(24.579132, $currentForecast->getTemperature()->getHighestValue());
        $this->assertInstanceOf(Celsius::class, $currentForecast->getTemperature()->getUnit());
        $this->assertEquals('Celsius', $currentForecast->getTemperature()->getUnit()->getName());
        $this->assertEquals('°C', $currentForecast->getTemperature()->getUnit()->getAbbreviation());
        $this->assertEquals('23°C', (string) $currentForecast->getTemperature());

        // Wind.
        $this->assertInstanceOf(Wind::class, $currentForecast->getWind());
        $this->assertInstanceOf(Speed::class, $currentForecast->getWind()->getSpeed());
        $this->assertIsFloat($currentForecast->getWind()->getSpeed()->getValue());
        $this->assertEquals(2.784574942897006, $currentForecast->getWind()->getSpeed()->getValue());
        $this->assertIsFloat($currentForecast->getWind()->getSpeed()->getLowestValue());
        $this->assertEquals(2.1742203, $currentForecast->getWind()->getSpeed()->getLowestValue());
        $this->assertIsFloat($currentForecast->getWind()->getSpeed()->getHighestValue());
        $this->assertEquals(3.372418, $currentForecast->getWind()->getSpeed()->getHighestValue());
        $this->assertInstanceOf(MetersPerSecond::class, $currentForecast->getWind()->getSpeed()->getUnit());
        $this->assertEquals('Meters per second', $currentForecast->getWind()->getSpeed()->getUnit()->getName());
        $this->assertEquals('m/s', $currentForecast->getWind()->getSpeed()->getUnit()->getAbbreviation());
        $this->assertEquals('2.8 m/s', (string) $currentForecast->getWind()->getSpeed());
        $this->assertEquals('2.8 m/s', (string) $currentForecast->getWind());
        $this->assertInstanceOf(Direction::class, $currentForecast->getWind()->getDirection());
        $this->assertEquals('Syd', $currentForecast->getWind()->getDirection()->getDirection());
        $this->assertEquals('S', $currentForecast->getWind()->getDirection()->getAbbreviation());
        $this->assertIsFloat($currentForecast->getWind()->getDirection()->getDegrees());
        $this->assertEquals(195.00374211733555, $currentForecast->getWind()->getDirection()->getDegrees());
        $this->assertEquals('Syd', (string) $currentForecast->getWind()->getDirection());
        $this->assertInstanceOf(Gust::class, $currentForecast->getWind()->getGust());
        $this->assertEquals(7.736926, $currentForecast->getWind()->getGust()->getValue());
        $this->assertInstanceOf(MetersPerSecond::class, $currentForecast->getWind()->getGust()->getUnit());
        $this->assertEquals('Meters per second', $currentForecast->getWind()->getGust()->getUnit()->getName());
        $this->assertEquals('m/s', $currentForecast->getWind()->getGust()->getUnit()->getAbbreviation());
        $this->assertEquals('7.7 m/s', (string) $currentForecast->getWind()->getGust());

        // Humidity.
        $this->assertInstanceOf(Humidity::class, $currentForecast->getHumidity());
        $this->assertIsFloat($currentForecast->getHumidity()->getValue());
        $this->assertEquals(52.539135, $currentForecast->getHumidity()->getValue());
        $this->assertInstanceOf(Percentage::class, $currentForecast->getHumidity()->getUnit());
        $this->assertEquals('Percentage', $currentForecast->getHumidity()->getUnit()->getName());
        $this->assertEquals('%', $currentForecast->getHumidity()->getUnit()->getAbbreviation());
        $this->assertEquals('53%', (string) $currentForecast->getHumidity());

        // Pressure.
        $this->assertInstanceOf(Pressure::class, $currentForecast->getPressure());
        $this->assertIsFloat($currentForecast->getPressure()->getValue());
        $this->assertEquals(1010.11127, $currentForecast->getPressure()->getValue());
        $this->assertInstanceOf(Hectopascal::class, $currentForecast->getPressure()->getUnit());
        $this->assertEquals('Hectopascal', $currentForecast->getPressure()->getUnit()->getName());
        $this->assertEquals('hPa', $currentForecast->getPressure()->getUnit()->getAbbreviation());
        $this->assertEquals('1010 hPa', (string) $currentForecast->getPressure());

        // Precipitation.
        $this->assertInstanceOf(Precipitation::class, $currentForecast->getPrecipitation());
        $this->assertEquals('regn', $currentForecast->getPrecipitation()->getType());
        $this->assertIsFloat($currentForecast->getPrecipitation()->getValue());
        $this->assertEquals(0.0, $currentForecast->getPrecipitation()->getValue());
        $this->assertIsFloat($currentForecast->getPrecipitation()->getLowestValue());
        $this->assertEquals(0.0, $currentForecast->getPrecipitation()->getLowestValue());
        $this->assertIsFloat($currentForecast->getPrecipitation()->getHighestValue());
        $this->assertEquals(0.0, $currentForecast->getPrecipitation()->getHighestValue());
        $this->assertInstanceOf(Millimeter::class, $currentForecast->getPrecipitation()->getUnit());
        $this->assertEquals('Millimeter', $currentForecast->getPrecipitation()->getUnit()->getName());
        $this->assertEquals('mm', $currentForecast->getPrecipitation()->getUnit()->getAbbreviation());
        $this->assertEquals('0.0 mm', (string) $currentForecast->getPrecipitation());

        // Visibility.
        $this->assertInstanceOf(Visibility::class, $currentForecast->getVisibility());
        $this->assertIsFloat($currentForecast->getVisibility()->getValue());
        $this->assertEquals(41843.824, $currentForecast->getVisibility()->getValue());
        $this->assertInstanceOf(Meter::class, $currentForecast->getVisibility()->getUnit());
        $this->assertEquals('Meter', $currentForecast->getVisibility()->getUnit()->getName());
        $this->assertEquals('m', $currentForecast->getVisibility()->getUnit()->getAbbreviation());
        $this->assertEquals('41843 m', (string) $currentForecast->getVisibility());

        // Timestamp.
        $this->assertInstanceOf(DateTime::class, $currentForecast->getTimestamp());
        $this->assertEquals('2019-06-30 09:00:00', $currentForecast->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $currentForecast->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test hourly forecast for location.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testHourlyForecast() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, false,false);

        // Get hourly forecast collection.
        $hourlyForecast = $location->getHourlyForecast();
        $this->assertInstanceOf(Collection::class, $hourlyForecast);
        $this->assertCount(96, $hourlyForecast);
        $this->assertArrayHasKey('20190630090000', $hourlyForecast->take(1)->toArray());

        // Get a hour instance.
        $hour = $hourlyForecast->first();
        $this->assertInstanceOf(Hour::class, $hour);

        // Temperature.
        $this->assertInstanceOf(Temperature::class, $hour->getTemperature());
        $this->assertIsFloat($hour->getTemperature()->getValue());
        $this->assertEquals(23.197327, $hour->getTemperature()->getValue());
        $this->assertIsFloat($hour->getTemperature()->getLowestValue());
        $this->assertEquals(22.539215, $hour->getTemperature()->getLowestValue());
        $this->assertIsFloat($hour->getTemperature()->getHighestValue());
        $this->assertEquals(24.579132, $hour->getTemperature()->getHighestValue());
        $this->assertInstanceOf(Celsius::class, $hour->getTemperature()->getUnit());
        $this->assertEquals('Celsius', $hour->getTemperature()->getUnit()->getName());
        $this->assertEquals('°C', $hour->getTemperature()->getUnit()->getAbbreviation());
        $this->assertEquals('23°C', (string) $hour->getTemperature());

        // Wind.
        $this->assertInstanceOf(Wind::class, $hour->getWind());
        $this->assertInstanceOf(Speed::class, $hour->getWind()->getSpeed());
        $this->assertIsFloat($hour->getWind()->getSpeed()->getValue());
        $this->assertEquals(2.784574942897006, $hour->getWind()->getSpeed()->getValue());
        $this->assertIsFloat($hour->getWind()->getSpeed()->getLowestValue());
        $this->assertEquals(2.1742203, $hour->getWind()->getSpeed()->getLowestValue());
        $this->assertIsFloat($hour->getWind()->getSpeed()->getHighestValue());
        $this->assertEquals(3.372418, $hour->getWind()->getSpeed()->getHighestValue());
        $this->assertInstanceOf(MetersPerSecond::class, $hour->getWind()->getSpeed()->getUnit());
        $this->assertEquals('Meters per second', $hour->getWind()->getSpeed()->getUnit()->getName());
        $this->assertEquals('m/s', $hour->getWind()->getSpeed()->getUnit()->getAbbreviation());
        $this->assertEquals('2.8 m/s', (string) $hour->getWind()->getSpeed());
        $this->assertEquals('2.8 m/s', (string) $hour->getWind());
        $this->assertInstanceOf(Direction::class, $hour->getWind()->getDirection());
        $this->assertEquals('Syd', $hour->getWind()->getDirection()->getDirection());
        $this->assertEquals('S', $hour->getWind()->getDirection()->getAbbreviation());
        $this->assertIsFloat($hour->getWind()->getDirection()->getDegrees());
        $this->assertEquals(195.00374211733555, $hour->getWind()->getDirection()->getDegrees());
        $this->assertEquals('Syd', (string) $hour->getWind()->getDirection());
        $this->assertInstanceOf(Gust::class, $hour->getWind()->getGust());
        $this->assertEquals(7.736926, $hour->getWind()->getGust()->getValue());
        $this->assertInstanceOf(MetersPerSecond::class, $hour->getWind()->getGust()->getUnit());
        $this->assertEquals('Meters per second', $hour->getWind()->getGust()->getUnit()->getName());
        $this->assertEquals('m/s', $hour->getWind()->getGust()->getUnit()->getAbbreviation());
        $this->assertEquals('7.7 m/s', (string) $hour->getWind()->getGust());

        // Humidity.
        $this->assertInstanceOf(Humidity::class, $hour->getHumidity());
        $this->assertIsFloat($hour->getHumidity()->getValue());
        $this->assertEquals(52.539135, $hour->getHumidity()->getValue());
        $this->assertInstanceOf(Percentage::class, $hour->getHumidity()->getUnit());
        $this->assertEquals('Percentage', $hour->getHumidity()->getUnit()->getName());
        $this->assertEquals('%', $hour->getHumidity()->getUnit()->getAbbreviation());
        $this->assertEquals('53%', (string) $hour->getHumidity());

        // Pressure.
        $this->assertInstanceOf(Pressure::class, $hour->getPressure());
        $this->assertIsFloat($hour->getPressure()->getValue());
        $this->assertEquals(1010.11127, $hour->getPressure()->getValue());
        $this->assertInstanceOf(Hectopascal::class, $hour->getPressure()->getUnit());
        $this->assertEquals('Hectopascal', $hour->getPressure()->getUnit()->getName());
        $this->assertEquals('hPa', $hour->getPressure()->getUnit()->getAbbreviation());
        $this->assertEquals('1010 hPa', (string) $hour->getPressure());

        // Precipitation.
        $this->assertInstanceOf(Precipitation::class, $hour->getPrecipitation());
        $this->assertEquals('regn', $hour->getPrecipitation()->getType());
        $this->assertIsFloat($hour->getPrecipitation()->getValue());
        $this->assertEquals(0.0, $hour->getPrecipitation()->getValue());
        $this->assertIsFloat($hour->getPrecipitation()->getLowestValue());
        $this->assertEquals(0.0, $hour->getPrecipitation()->getLowestValue());
        $this->assertIsFloat($hour->getPrecipitation()->getHighestValue());
        $this->assertEquals(0.0, $hour->getPrecipitation()->getHighestValue());
        $this->assertInstanceOf(Millimeter::class, $hour->getPrecipitation()->getUnit());
        $this->assertEquals('Millimeter', $hour->getPrecipitation()->getUnit()->getName());
        $this->assertEquals('mm', $hour->getPrecipitation()->getUnit()->getAbbreviation());
        $this->assertEquals('0.0 mm', (string) $hour->getPrecipitation());

        // Visibility.
        $this->assertInstanceOf(Visibility::class, $hour->getVisibility());
        $this->assertIsFloat($hour->getVisibility()->getValue());
        $this->assertEquals(41843.824, $hour->getVisibility()->getValue());
        $this->assertInstanceOf(Meter::class, $hour->getVisibility()->getUnit());
        $this->assertEquals('Meter', $hour->getVisibility()->getUnit()->getName());
        $this->assertEquals('m', $hour->getVisibility()->getUnit()->getAbbreviation());
        $this->assertEquals('41843 m', (string) $hour->getVisibility());

        // Timestamp.
        $this->assertInstanceOf(DateTime::class, $hour->getTimestamp());
        $this->assertEquals('2019-06-30 09:00:00', $hour->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $hour->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test daily forecast for location.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testDailyForecast() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, false,false);

        // Get daily forecast collection.
        $dailyForecast = $location->getDailyForecast();
        $this->assertInstanceOf(Collection::class, $dailyForecast);
        $this->assertCount(11, $dailyForecast);
        $this->assertArrayHasKey('20190630', $dailyForecast->take(1)->toArray());

        // Get a day instance.
        $day = $dailyForecast->first();
        $this->assertInstanceOf(Day::class, $day);

        // Temperature.
        $this->assertInstanceOf(Temperature::class, $day->getTemperature());
        $this->assertIsFloat($day->getTemperature()->getValue());
        $this->assertEquals(26.173122333333335, $day->getTemperature()->getValue());
        $this->assertIsFloat($day->getTemperature()->getLowestValue());
        $this->assertEquals(24.402496266666663, $day->getTemperature()->getLowestValue());
        $this->assertIsFloat($day->getTemperature()->getHighestValue());
        $this->assertEquals(28.8825336, $day->getTemperature()->getHighestValue());
        $this->assertInstanceOf(Celsius::class, $day->getTemperature()->getUnit());
        $this->assertEquals('Celsius', $day->getTemperature()->getUnit()->getName());
        $this->assertEquals('°C', $day->getTemperature()->getUnit()->getAbbreviation());
        $this->assertEquals('26°C', (string) $day->getTemperature());

        // Wind.
        $this->assertInstanceOf(Wind::class, $day->getWind());
        $this->assertInstanceOf(Speed::class, $day->getWind()->getSpeed());
        $this->assertIsFloat($day->getWind()->getSpeed()->getValue());
        $this->assertEquals(4.7881474947600156, $day->getWind()->getSpeed()->getValue());
        $this->assertIsFloat($day->getWind()->getSpeed()->getLowestValue());
        $this->assertEquals(4.04755224, $day->getWind()->getSpeed()->getLowestValue());
        $this->assertIsFloat($day->getWind()->getSpeed()->getHighestValue());
        $this->assertEquals(5.744137033333334, $day->getWind()->getSpeed()->getHighestValue());
        $this->assertInstanceOf(MetersPerSecond::class, $day->getWind()->getSpeed()->getUnit());
        $this->assertEquals('Meters per second', $day->getWind()->getSpeed()->getUnit()->getName());
        $this->assertEquals('m/s', $day->getWind()->getSpeed()->getUnit()->getAbbreviation());
        $this->assertEquals('4.8 m/s', (string) $day->getWind()->getSpeed());
        $this->assertEquals('4.8 m/s', (string) $day->getWind());
        $this->assertInstanceOf(Direction::class, $day->getWind()->getDirection());
        $this->assertEquals('Sydvest', $day->getWind()->getDirection()->getDirection());
        $this->assertEquals('SV', $day->getWind()->getDirection()->getAbbreviation());
        $this->assertIsFloat($day->getWind()->getDirection()->getDegrees());
        $this->assertEquals(245.45667629457967, $day->getWind()->getDirection()->getDegrees());
        $this->assertEquals('Sydvest', (string) $day->getWind()->getDirection());
        $this->assertInstanceOf(Gust::class, $day->getWind()->getGust());
        $this->assertEquals(11.177295293333334, $day->getWind()->getGust()->getValue());
        $this->assertInstanceOf(MetersPerSecond::class, $day->getWind()->getGust()->getUnit());
        $this->assertEquals('Meters per second', $day->getWind()->getGust()->getUnit()->getName());
        $this->assertEquals('m/s', $day->getWind()->getGust()->getUnit()->getAbbreviation());
        $this->assertEquals('11.2 m/s', (string) $day->getWind()->getGust());

        // Humidity.
        $this->assertInstanceOf(Humidity::class, $day->getHumidity());
        $this->assertIsFloat($day->getHumidity()->getValue());
        $this->assertEquals(49.01870573333334, $day->getHumidity()->getValue());
        $this->assertInstanceOf(Percentage::class, $day->getHumidity()->getUnit());
        $this->assertEquals('Percentage', $day->getHumidity()->getUnit()->getName());
        $this->assertEquals('%', $day->getHumidity()->getUnit()->getAbbreviation());
        $this->assertEquals('49%', (string) $day->getHumidity());

        // Pressure.
        $this->assertInstanceOf(Pressure::class, $day->getPressure());
        $this->assertIsFloat($day->getPressure()->getValue());
        $this->assertEquals(1007.348856, $day->getPressure()->getValue());
        $this->assertInstanceOf(Hectopascal::class, $day->getPressure()->getUnit());
        $this->assertEquals('Hectopascal', $day->getPressure()->getUnit()->getName());
        $this->assertEquals('hPa', $day->getPressure()->getUnit()->getAbbreviation());
        $this->assertEquals('1007 hPa', (string) $day->getPressure());

        // Precipitation.
        $this->assertInstanceOf(Precipitation::class, $day->getPrecipitation());
        $this->assertEquals('regn', $day->getPrecipitation()->getType());
        $this->assertIsFloat($day->getPrecipitation()->getValue());
        $this->assertEquals(0.0, $day->getPrecipitation()->getValue());
        $this->assertIsFloat($day->getPrecipitation()->getLowestValue());
        $this->assertEquals(0.0, $day->getPrecipitation()->getLowestValue());
        $this->assertIsFloat($day->getPrecipitation()->getHighestValue());
        $this->assertEquals(0.0, $day->getPrecipitation()->getHighestValue());
        $this->assertInstanceOf(Millimeter::class, $day->getPrecipitation()->getUnit());
        $this->assertEquals('Millimeter', $day->getPrecipitation()->getUnit()->getName());
        $this->assertEquals('mm', $day->getPrecipitation()->getUnit()->getAbbreviation());
        $this->assertEquals('0.0 mm', (string) $day->getPrecipitation());

        // Visibility.
        $this->assertInstanceOf(Visibility::class, $day->getVisibility());
        $this->assertIsFloat($day->getVisibility()->getValue());
        $this->assertEquals(29539.1524000000034, $day->getVisibility()->getValue());
        $this->assertInstanceOf(Meter::class, $day->getVisibility()->getUnit());
        $this->assertEquals('Meter', $day->getVisibility()->getUnit()->getName());
        $this->assertEquals('m', $day->getVisibility()->getUnit()->getAbbreviation());
        $this->assertEquals('29539 m', (string) $day->getVisibility());

        // Timestamp.
        $this->assertInstanceOf(DateTime::class, $day->getTimestamp());
        $this->assertEquals('2019-06-30 12:00:00', $day->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $day->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test regional forecast for location.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testRegionalForecast() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, true, false);

        // Get regional forecast collection.
        $regionalForecast = $location->getRegionalForecast();
        $this->assertInstanceOf(Text::class, $regionalForecast);
        $this->assertEquals('Først skyet med tordenbyger, senere nogen sol og kun få byger', $regionalForecast->getTitle());
        $this->assertEquals(
            'Først skyet med byger, lokalt med torden, men omkring middag klarer det op med nogen sol, dog med mulighed for en lokal byge. Temp. op mellem 17 og 20 grader. I nat mest tørt og klart vejr. Temp. ned mellem 8 og 13 grader. Hele døgnet svag til jævn vind fra vest og nordvest, ved kysterne op til frisk.',
            $regionalForecast->getText()
        );
        $this->assertEquals('Mandag den 8. juli 2019.', $regionalForecast->getDate());
        $this->assertEquals('Udsigt, der gælder til tirsdag morgen, udsendt kl. 09.40', $regionalForecast->getValidity());
        $this->assertInstanceOf(DateTime::class, $regionalForecast->getIssuedAt());
        $this->assertEquals('2019-07-08 09:41:47', $regionalForecast->getIssuedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $regionalForecast->getIssuedAt()->getTimezone()->getName());
    }

    /**
     * Test without warnings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithoutWarnings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocation());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, false,false);

        // Assert that current forecast contains no warnings.
        $this->assertNull($location->getCurrentlyForecast()->getWarnings());

        // Assert that none of the hourly forecasts contains any warnings.
        $hourlyForecast = $location->getHourlyForecast();
        $hourlyForecast->each(function ($hour) {
            /* @var $hour \Rugaard\DMI\DTO\Forecast\Hour */
            $this->assertNull($hour->getWarnings());
        });

        // Assert that none of the daily forecasts contains any warnings.
        $dailyForecast = $location->getDailyForecast();
        $dailyForecast->each(function ($day) {
            /* @var $day \Rugaard\DMI\DTO\Forecast\Day */
            $this->assertNull($day->getWarnings());
        });
    }

    /**
     * Test by ID with empty warnings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testByIdWithEmptyWarnings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocationWithEmptyWarnings());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, false);

        // Assert that current forecast contains no warnings.
        $this->assertNull($location->getCurrentlyForecast()->getWarnings());

        // Assert that none of the hourly forecasts contains any warnings.
        $hourlyForecast = $location->getHourlyForecast();
        $hourlyForecast->each(function ($hour) {
            /* @var $hour \Rugaard\DMI\DTO\Forecast\Hour */
            $this->assertNull($hour->getWarnings());
        });

        // Assert that none of the daily forecasts contains any warnings.
        $dailyForecast = $location->getDailyForecast();
        $dailyForecast->each(function ($day) {
            /* @var $day \Rugaard\DMI\DTO\Forecast\Day */
            $this->assertNull($day->getWarnings());
        });
    }

    /**
     * Test by ID with warnings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testByIdWithWarnings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocationWithWarnings());

        // Get location.
        $location = $dmi->location($this->mockedLocationId, false);

        // Assert that current forecast contains a Collection of warnings.
        $currentForecast = $location->getCurrentlyForecast();
        $this->assertInstanceOf(Collection::class, $currentForecast->getWarnings());
        $this->assertCount(1, $currentForecast->getWarnings());

        // Assert that the first 7 hours contains a Collection of warnings,
        // but the 8th does not (warning is expired).
        $hourlyForecast = $location->getHourlyForecast()->take(8);
        $hourlyForecast->each(function ($hour, $key) {
            /* @var $hour \Rugaard\DMI\DTO\Forecast\Hour */
            if ($key === 20190630160000) {
                $this->assertNull($hour->getWarnings());
            } else {
                $this->assertInstanceOf(Collection::class, $hour->getWarnings());
                $this->assertCount(1, $hour->getWarnings());
            }
        });

        // Assert that first two days contains a Collection of warnings,
        // but the 3rd does not (warning is expired).
        $dailyForecast = $location->getDailyForecast()->take(3);
        $dailyForecast->each(function ($day, $key) {
            /* @var $day \Rugaard\DMI\DTO\Forecast\Day */
            if ($key === 20190702) {
                $this->assertNull($day->getWarnings());
            } else {
                $this->assertInstanceOf(Collection::class, $day->getWarnings());
                $this->assertCount(1, $day->getWarnings());
            }
        });
    }

    /**
     * Test by coordinate with empty warnings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testByCoordinateWithEmptyWarnings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocationWithEmptyWarnings());

        // Get location by coordinate (aka. nearest weather station).
        $location = $dmi->locationByCoordinate($this->mockedCoordinate['latitude'], $this->mockedCoordinate['longitude'], false);

        // Assert that current forecast contains no warnings.
        $this->assertNull($location->getCurrentlyForecast()->getWarnings());

        // Assert that none of the hourly forecasts contains any warnings.
        $hourlyForecast = $location->getHourlyForecast();
        $hourlyForecast->each(function ($hour) {
            /* @var $hour \Rugaard\DMI\DTO\Forecast\Hour */
            $this->assertNull($hour->getWarnings());
        });

        // Assert that none of the daily forecasts contains any warnings.
        $dailyForecast = $location->getDailyForecast();
        $dailyForecast->each(function ($day) {
            /* @var $day \Rugaard\DMI\DTO\Forecast\Day */
            $this->assertNull($day->getWarnings());
        });
    }

    /**
     * Test by coordinate with warnings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testByCoordinateWithWarnings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockLocationWithWarnings());

        // Get location by coordinate (aka. nearest weather station).
        $location = $dmi->locationByCoordinate($this->mockedCoordinate['latitude'], $this->mockedCoordinate['longitude'], false);

        // Assert that current forecast contains a Collection of warnings.
        $currentForecast = $location->getCurrentlyForecast();
        $this->assertInstanceOf(Collection::class, $currentForecast->getWarnings());
        $this->assertCount(1, $currentForecast->getWarnings());

        // Assert that the first 7 hours contains a Collection of warnings,
        // but the 8th does not (warning is expired).
        $hourlyForecast = $location->getHourlyForecast()->take(8);
        $hourlyForecast->each(function ($hour, $key) {
            /* @var $hour \Rugaard\DMI\DTO\Forecast\Hour */
            if ($key === 20190630160000) {
                $this->assertNull($hour->getWarnings());
            } else {
                $this->assertInstanceOf(Collection::class, $hour->getWarnings());
                $this->assertCount(1, $hour->getWarnings());
            }
        });

        // Assert that first two days contains a Collection of warnings,
        // but the 3rd does not (warning is expired).
        $dailyForecast = $location->getDailyForecast()->take(3);
        $dailyForecast->each(function ($day, $key) {
            /* @var $day \Rugaard\DMI\DTO\Forecast\Day */
            if ($key === 20190702) {
                $this->assertNull($day->getWarnings());
            } else {
                $this->assertInstanceOf(Collection::class, $day->getWarnings());
                $this->assertCount(1, $day->getWarnings());
            }
        });
    }

    /**
     * Test failed request by ID.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testFailedRequestById() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockInternalErrorRequest());

        // Assert expectation of exception.
        $this->expectException(DMIException::class);

        // Get location.
        $dmi->location($this->mockedLocationId);
    }

    /**
     * Test failed request by coordinate.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testFailedRequest() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockInternalErrorRequest());

        // Assert expectation of exception.
        $this->expectException(DMIException::class);

        // Get location by coordinate (aka. nearest weather station).
        $dmi->locationByCoordinate($this->mockedCoordinate['latitude'], $this->mockedCoordinate['longitude']);
    }
}