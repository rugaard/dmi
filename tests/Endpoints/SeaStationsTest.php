<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\SeaStation;
use Rugaard\DMI\Endpoints\SeaStations;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class SeaStationsTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class SeaStationsTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Mocked sea station ID.
     *
     * @var int|null
     */
    protected $mockedSeaStationId;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp(): void
    {
        // Set a mocked sea station ID.
        $this->mockedSeaStationId = 30336;

        parent::setUp();
    }

    /**
     * Test basic details.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testBasics() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSeaStations());

        // Get sea stations.
        $seaStations = $dmi->seaStations();

        // Assertions.
        $this->assertInstanceOf(SeaStations::class, $seaStations);
        $this->assertInstanceOf(Collection::class, $seaStations->getData());
        $this->assertCount(92, $seaStations->getData());
        $this->assertInstanceOf(SeaStation::class, $seaStations->getData()->first());
    }

    /**
     * Test basic details without any sun times.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptySeaStations() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptySeaStations());

        // Get sea stations.
        $seaStations = $dmi->seaStations();

        // Assertions.
        $this->assertInstanceOf(SeaStations::class, $seaStations);
        $this->assertIsArray($seaStations->getData());
        $this->assertCount(0, $seaStations->getData());
    }

    /**
     * Test sea station.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testSeaStationById() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSeaStations());

        // Get sea stations.
        $seaStation = $dmi->seaStation($this->mockedSeaStationId);

        // Assertions.
        $this->assertInstanceOf(SeaStation::class, $seaStation);
        $this->assertIsInt($seaStation->getId());
        $this->assertEquals(30336, $seaStation->getId());
        $this->assertEquals('København', $seaStation->getName());
        $this->assertEquals('Københavns Havn', $seaStation->getLocation());
        $this->assertIsFloat($seaStation->getLatitude());
        $this->assertEquals(55.7042007, $seaStation->getLatitude());
        $this->assertIsFloat($seaStation->getLongitude());
        $this->assertEquals(12.5987997, $seaStation->getLongitude());
        $this->assertEquals('DNK', $seaStation->getCountry());
        $this->assertIsInt($seaStation->getYear20Event());
        $this->assertEquals(143, $seaStation->getYear20Event());
        $this->assertTrue($seaStation->getLevelMeasurement());
        $this->assertTrue($seaStation->getTemperatureMeasurement());
        $this->assertFalse($seaStation->getSalinityMeasurement());
        $this->assertFalse($seaStation->getCurrentMeasurement());
        $this->assertFalse($seaStation->getWaveMeasurement());
        $this->assertTrue($seaStation->getTideMeasurement());
        $this->assertInstanceOf(Collection::class, $seaStation->getMeta());
        $this->assertTrue($seaStation->getMeta()->has('counter'));
        $this->assertIsInt($seaStation->getMeta()->get('counter'));
        $this->assertEquals(5038286, $seaStation->getMeta()->get('counter'));
        $this->assertTrue($seaStation->getMeta()->has('machineIdentifier'));
        $this->assertIsInt($seaStation->getMeta()->get('machineIdentifier'));
        $this->assertEquals(4848699, $seaStation->getMeta()->get('machineIdentifier'));
        $this->assertTrue($seaStation->getMeta()->has('processIdentifier'));
        $this->assertIsInt($seaStation->getMeta()->get('processIdentifier'));
        $this->assertEquals(3788, $seaStation->getMeta()->get('processIdentifier'));
        $this->assertTrue($seaStation->getMeta()->has('timestamp'));
        $this->assertInstanceOf(DateTime::class, $seaStation->getMeta()->get('timestamp'));
        $this->assertEquals('2017-02-23 08:23:58', $seaStation->getMeta()->get('timestamp')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $seaStation->getMeta()->get('timestamp')->getTimezone()->getName());
        $this->assertNull($seaStation->getObservations());
        $this->assertNull($seaStation->getForecast());
    }

    /**
     * Test observations.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testObservations() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSeaStationsWithObservations());

        // Get sea stations.
        $seaStation = $dmi->seaStation($this->mockedSeaStationId, true);

        // Get observations.
        $observations = $seaStation->getObservations();

        // Assertions.
        $this->assertInstanceOf(Collection::class, $observations);
        $this->assertTrue($observations->has('lastUpdated'));
        $this->assertInstanceOf(DateTime::class, $observations->get('lastUpdated'));
        $this->assertEquals('2019-06-30 07:13:48', $observations->get('lastUpdated')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $observations->get('lastUpdated')->getTimezone()->getName());
        $this->assertTrue($observations->has('data'));
        $this->assertInstanceOf(Collection::class, $observations->get('data'));

        // Assert observation data entry.
        $observation = $observations->get('data')->first();
        $this->assertInstanceOf(Collection::class, $observation);
        $this->assertTrue($observation->has('value'));
        $this->assertIsFloat($observation->get('value'));
        $this->assertEquals(2.0, $observation->get('value'));
        $this->assertTrue($observation->has('temperature'));
        $this->assertIsFloat($observation->get('temperature'));
        $this->assertEquals(18.75, $observation->get('temperature'));
        $this->assertTrue($observation->has('timestamp'));
        $this->assertInstanceOf(DateTime::class, $observation->get('timestamp'));
        $this->assertEquals('2019-06-28 07:20:00', $observation->get('timestamp')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $observation->get('timestamp')->getTimezone()->getName());

    }

    /**
     * Test forecast.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testForecast() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSeaStationsWithForecast());

        // Get sea stations.
        $seaStation = $dmi->seaStation($this->mockedSeaStationId, false, true);

        // Get forecast.
        $forecast = $seaStation->getForecast();

        // Assertions.
        $this->assertInstanceOf(Collection::class, $forecast);
        $this->assertTrue($forecast->has('lastUpdated'));
        $this->assertInstanceOf(DateTime::class, $forecast->get('lastUpdated'));
        $this->assertEquals('2019-06-30 07:13:48', $forecast->get('lastUpdated')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $forecast->get('lastUpdated')->getTimezone()->getName());
        $this->assertTrue($forecast->has('data'));
        $this->assertInstanceOf(Collection::class, $forecast->get('data'));

        // Assert forecast data entry.
        $entry = $forecast->get('data')->first();
        $this->assertInstanceOf(Collection::class, $entry);
        $this->assertTrue($entry->has('value'));
        $this->assertIsFloat($entry->get('value'));
        $this->assertEquals(8.0, $entry->get('value'));
        $this->assertTrue($entry->has('timestamp'));
        $this->assertInstanceOf(DateTime::class, $entry->get('timestamp'));
        $this->assertEquals('2019-06-30 07:20:00', $entry->get('timestamp')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $entry->get('timestamp')->getTimezone()->getName());
    }

    /**
     * Test failed request.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testFailedRequest() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockInternalErrorRequest());

        // Assert expectation of exception.
        $this->expectException(DMIException::class);

        // Get sea stations.
        $dmi->seaStations();
    }
}
