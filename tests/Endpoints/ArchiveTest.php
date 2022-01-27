<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use Rugaard\DMI\Client;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;

/**
 * Class ArchiveTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class ArchiveTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Test invalid measurement.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testInvalidMeasurement() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyArchive());

        // Expect exception.
        $this->expectException(DMIException::class);
        $this->expectExceptionMessage('Invalid measurement. Supported measurements are: "temperature", "precipitation", "wind", "wind-direction", "humidity", "pressure", "sun", "drought", "lightning", "snow"');

        // Get archive data.
        $dmi->archive('rainbow', 'daily', '2019-06-30');
    }

    /**
     * Test invalid frequency.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testInvalidFrequency() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyArchive());

        // Expect exception.
        $this->expectException(DMIException::class);
        $this->expectExceptionMessage('Invalid frequency. Supported frequencies are: "hourly", "daily", "monthly", "yearly"');

        // Get archive data.
        $dmi->archive('temperature', 'minutely', '2019-06-30');
    }

    /**
     * Test invalid period.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testInvalidPeriod() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyArchive());

        // Expect exception.
        $this->expectException(DMIException::class);
        $this->expectExceptionMessage('Invalid time period provided. Provide either a DateTime object or a string in the format corresponding to the frequency.');

        // Get archive data.
        $dmi->archive('temperature', 'daily', '2019');
    }

    /**
     * Test invalid municipality ID.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testInvalidMunicipalityId() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyArchive());

        // Expect exception.
        $this->expectException(DMIException::class);
        $this->expectExceptionMessage('Invalid municipality ID. Check the documentation for a list of municipality ID\'s.');

        // Get archive data.
        $dmi->archive('temperature', 'daily', '2019-06-30', 9999);
    }

    /**
     * Test invalid country.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testInvalidCountry() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyArchive());

        // Expect exception.
        $this->expectException(DMIException::class);
        $this->expectExceptionMessage('Invalid country. Supported countries are: "DK", "GL", "FO"');

        // Get archive data.
        $dmi->archive('temperature', 'daily', '2019-06-30', null, 'SV');
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

        // Get archive data.
        $dmi->archive('temperature', 'daily', '2019-06-30');
    }
}
