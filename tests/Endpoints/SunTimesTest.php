<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\SunTime;
use Rugaard\DMI\Endpoints\SunTimes;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class SunTimesTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class SunTimesTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Mocked location ID.
     *
     * @var int|null
     */
    protected $mockedLocationId;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Set a mocked location ID.
        $this->mockedLocationId = 2618425;

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
        $dmi = (new Client)->setClient($this->mockSunTimes());

        // Get sun times.
        $sunTimes = $dmi->sunTimes($this->mockedLocationId);

        // Assertions.
        $this->assertInstanceOf(SunTimes::class, $sunTimes);
        $this->assertInstanceOf(Collection::class, $sunTimes->getData());
        $this->assertCount(14, $sunTimes->getData());
    }

    /**
     * Test basic details with global ID.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithGlobalId() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = new Client($this->mockedLocationId, $this->mockSunTimes());

        // Get sun times.
        $sunTimes = $dmi->sunTimes();

        // Assertions.
        $this->assertInstanceOf(SunTimes::class, $sunTimes);
        $this->assertInstanceOf(Collection::class, $sunTimes->getData());
        $this->assertCount(14, $sunTimes->getData());
    }

    /**
     * Test basic details without any sun times.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptySunTime() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptySunTimes());

        // Get sun times.
        $sunTimes = $dmi->sunTimes($this->mockedLocationId);

        // Assertions.
        $this->assertInstanceOf(SunTimes::class, $sunTimes);
        $this->assertIsArray($sunTimes->getData());
        $this->assertCount(0, $sunTimes->getData());
    }

    /**
     * Test sun time DTO.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testSunTime() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSunTimes());

        // Get sun times.
        $sunTimes = $dmi->sunTimes($this->mockedLocationId);

        // Get a single sun time instance.
        /* @var $sunTime \Rugaard\DMI\DTO\SunTime */
        $sunTime = $sunTimes->getData()->first();

        // Assertions.
        $this->assertInstanceOf(SunTime::class, $sunTime);
        $this->assertInstanceOf(DateTime::class, $sunTime->getSunrise());
        $this->assertEquals('2019-06-30 04:29', $sunTime->getSunrise()->format('Y-m-d H:i'));
        $this->assertEquals('Europe/Copenhagen', $sunTime->getSunrise()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $sunTime->getSunset());
        $this->assertEquals('2019-06-30 21:56', $sunTime->getSunset()->format('Y-m-d H:i'));
        $this->assertEquals('Europe/Copenhagen', $sunTime->getSunset()->getTimezone()->getName());
    }

    /**
     * Test "toArray".
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testToArray() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSunTimes());

        // Get sun times.
        $sunTimes = $dmi->sunTimes($this->mockedLocationId);

        // Get a single sun time instance.
        $sunTime = $sunTimes->getData()->first()->toArray();

        // Assertions.
        $this->assertIsArray($sunTime);
        $this->assertArrayHasKey('sunrise', $sunTime);
        $this->assertEquals('2019-06-30 04:29', $sunTime['sunrise']->format('Y-m-d H:i'));
        $this->assertEquals('Europe/Copenhagen', $sunTime['sunrise']->getTimezone()->getName());
        $this->assertArrayHasKey('sunset', $sunTime);
        $this->assertEquals('2019-06-30 21:56', $sunTime['sunset']->format('Y-m-d H:i'));
        $this->assertEquals('Europe/Copenhagen', $sunTime['sunset']->getTimezone()->getName());
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

        // Get sun times.
        $dmi->sunTimes($this->mockedLocationId);
    }
}
