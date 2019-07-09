<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\DTO\SeaStation;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class SeaStationTest.
 *
 * @package Rugaard\DMI\Tests\DTO
 */
class SeaStationTest extends AbstractTestCase
{
    /**
     * Test set/get id.
     *
     * @return void
     */
    public function testId() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Mocked ID.
        $mockedId = 12345678;

        // Set ID.
        $dto->setId($mockedId);

        // Assertions.
        $this->assertIsInt($dto->getId());
        $this->assertEquals($mockedId, $dto->getId());
    }

    /**
     * Test set/get name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Mocked name.
        $mockedName = 'Mocked name';

        // Set name.
        $dto->setName($mockedName);

        // Assertions.
        $this->assertIsString($dto->getName());
        $this->assertEquals($mockedName, $dto->getName());
    }

    /**
     * Test set/get location.
     *
     * @return void
     */
    public function testLocation() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Mocked location.
        $mockedLocation = 'Mocked location';

        // Set location.
        $dto->setLocation($mockedLocation);

        // Assertions.
        $this->assertIsString($dto->getLocation());
        $this->assertEquals($mockedLocation, $dto->getLocation());
    }

    /**
     * Test set/get latitude.
     *
     * @return void
     */
    public function testLatitude() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

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
        $dto = new SeaStation;

        // Mocked longitude.
        $mockedLongitude = -12.3456789;

        // Set longitude.
        $dto->setLongitude($mockedLongitude);

        // Assertions.
        $this->assertIsFloat($dto->getLongitude());
        $this->assertEquals($mockedLongitude, $dto->getLongitude());
    }

    /**
     * Test set/get country.
     *
     * @return void
     */
    public function testCountry() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Mocked country.
        $mockedCountry = 'Mocked country';

        // Set country.
        $dto->setCountry($mockedCountry);

        // Assertions.
        $this->assertIsString($dto->getCountry());
        $this->assertEquals($mockedCountry, $dto->getCountry());
    }

    /**
     * Test set/get year 20 event.
     *
     * @return void
     */
    public function testYear20Event() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Mocked year 20 event.
        $mockedYear20Event = 100;

        // Set year 20 event.
        $dto->setYear20Event($mockedYear20Event);

        // Assertions.
        $this->assertIsInt($dto->getYear20Event());
        $this->assertEquals($mockedYear20Event, $dto->getYear20Event());
    }

    /**
     * Test set/get level measurement.
     *
     * @return void
     */
    public function testLevelMeasurement() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set level measurement.
        $dto->setLevelMeasurement(true);

        // Assertions.
        $this->assertIsBool($dto->getLevelMeasurement());
        $this->assertTrue($dto->getLevelMeasurement());
    }

    /**
     * Test set/get temperature measurement.
     *
     * @return void
     */
    public function testTemperatureMeasurement() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set temperature measurement.
        $dto->setTemperatureMeasurement(true);

        // Assertions.
        $this->assertIsBool($dto->getTemperatureMeasurement());
        $this->assertTrue($dto->getTemperatureMeasurement());
    }

    /**
     * Test set/get salinity measurement.
     *
     * @return void
     */
    public function testSalinityMeasurement() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set salinity measurement.
        $dto->setSalinityMeasurement(true);

        // Assertions.
        $this->assertIsBool($dto->getSalinityMeasurement());
        $this->assertTrue($dto->getSalinityMeasurement());
    }

    /**
     * Test set/get current measurement.
     *
     * @return void
     */
    public function testCurrentMeasurement() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set current measurement.
        $dto->setCurrentMeasurement(true);

        // Assertions.
        $this->assertIsBool($dto->getCurrentMeasurement());
        $this->assertTrue($dto->getCurrentMeasurement());
    }

    /**
     * Test set/get wave measurement.
     *
     * @return void
     */
    public function testWaveMeasurement() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set wave measurement.
        $dto->setWaveMeasurement(true);

        // Assertions.
        $this->assertIsBool($dto->getWaveMeasurement());
        $this->assertTrue($dto->getWaveMeasurement());
    }

    /**
     * Test set/get tide measurement.
     *
     * @return void
     */
    public function testTideMeasurement() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set tide measurement.
        $dto->setTideMeasurement(true);

        // Assertions.
        $this->assertIsBool($dto->getTideMeasurement());
        $this->assertTrue($dto->getTideMeasurement());
    }

    /**
     * Test set/get meta.
     *
     * @return void
     */
    public function testMeta() : void
    {
        // Mocked timestamp.
        $mockedTimestamp = '2019-06-30 11:11:11';

        // Mocked test data.
        $mockedData = [
            'counter' => 12345678,
            'machineIdentifier' => 987654321,
            'processIdentifier' => 135792468,
            'timestamp' => DateTime::createFromFormat('Y-m-d H:i:s', $mockedTimestamp, new DateTimeZone('Europe/Copenhagen'))->format('U')
        ];

        // Instantiate empty DTO.
        $dto = new SeaStation;

        // Set meta.
        $dto->setMeta($mockedData);

        // Assertions.
        Collection::make($mockedData)->each(function ($value, $key) use ($dto, $mockedTimestamp) {
            // Get meta data.
            /* @var $meta \Tightenco\Collect\Support\Collection */
            $meta = $dto->getMeta();

            if ($key === 'timestamp') {
                $this->assertInstanceOf(DateTime::class, $meta->get($key));
                $this->assertEquals($mockedTimestamp, $meta->get($key)->format('Y-m-d H:i:s'));
                $this->assertEquals('Europe/Copenhagen', $meta->get($key)->getTimezone()->getName());
            } else {
                $this->assertIsInt($meta->get($key));
                $this->assertEquals($value, $meta->get($key));
            }
        });
    }

    /**
     * Test set/get observations.
     *
     * @return void
     */
    public function testObservations() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation();

        // Set observations.
        $dto->setObservations(Collection::make());

        // Assertion.
        $this->assertInstanceOf(Collection::class, $dto->getObservations());
    }

    /**
     * Test set/get forecast.
     *
     * @return void
     */
    public function testForecast() : void
    {
        // Instantiate empty DTO.
        $dto = new SeaStation();

        // Set forecast.
        $dto->setForecast(Collection::make());

        // Assertion.
        $this->assertInstanceOf(Collection::class, $dto->getForecast());
    }
}