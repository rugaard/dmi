<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Support\MockedResponses;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Trait MockedResponses
 *
 * @package Rugaard\DMI\Old\Tests\Support\MockedResponses
 */
trait MockedResponses
{
    /**
     * Mocked search response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockSearch() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Search/Search.json')),
        ]);
    }

    /**
     * Mocked empty search response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptySearch() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Search/EmptySearch.json')),
        ]);
    }

    /**
     * Mocked forecast response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockForecast() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Forecasts/National.json')),
        ]);
    }

    /**
     * Mocked extended forecast response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockExtendedForecast() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Forecasts/National-7days.json')),
        ]);
    }

    /**
     * Mocked location response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockLocation() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Location.json')),
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Forecasts/Regional.json')),
        ]);
    }

    /**
     * Mocked location with empty regional response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockLocationWithEmptyRegional() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Location.json')),
            new GuzzleResponse(200, [], '{}'),
        ]);
    }

    /**
     * Mocked location with failed regional forecast response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockLocationWithFailedRegional() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Location.json')),
            new GuzzleResponse(500, [], null),
        ]);
    }

    /**
     * Mocked location with warnings response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockLocationWithWarnings() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Location.json')),
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Warnings/Location/Warnings.json')),
        ]);
    }

    /**
     * Mocked location with empty warnings response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockLocationWithEmptyWarnings() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Location.json')),
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Warnings/Location/NoWarnings.json')),
        ]);
    }

    /**
     * Mocked sun times response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockSunTimes() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/SunTimes.json')),
        ]);
    }

    /**
     * Mocked empty sun times response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptySunTimes() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], '[]'),
        ]);
    }

    /**
     * Mocked UV response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockUV() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/UV/UVLowModerate.json')),
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/UV/UVHighExtreme.json')),
        ]);
    }

    /**
     * Mocked empty UV response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptyUV() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], '{ "UV":{}, "sunUpDown":[] }'),
        ]);
    }

    /**
     * Mocked pollen response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockPollen() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Pollen.json')),
        ]);
    }

    /**
     * Mocked empty pollen response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptyPollen() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], '[{}]'),
        ]);
    }

    /**
     * Mocked warnings response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockWarnings() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Warnings/Warnings.json')),
        ]);
    }

    /**
     * Mocked empty warnings response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptyWarnings() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], '{}'),
        ]);
    }

    /**
     * Mocked sea stations response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockSeaStations() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/SeaStations/SeaStations.json')),
        ]);
    }

    /**
     * Mocked empty sea stations response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptySeaStations() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], '[]'),
        ]);
    }

    /**
     * Mocked sea stations with observations response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockSeaStationsWithObservations() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/SeaStations/SeaStations.json')),
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/SeaStations/Observations.json')),
        ]);
    }

    /**
     * Mocked sea stations with forecast response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockSeaStationsWithForecast() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/SeaStations/SeaStations.json')),
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/SeaStations/Forecast.json')),
        ]);
    }

    /**
     * Mocked archive response.
     *
     * @param  string $frequency
     * @param  string $type
     * @return \GuzzleHttp\Client
     */
    private function mockArchive(string $frequency, string $type) : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], file_get_contents(__DIR__ . '/JSON/Archive/' . ucfirst($type) .'.json')),
        ]);
    }

    /**
     * Mocked empty archive response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockEmptyArchive() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], '[]'),
        ]);
    }

    /**
     * Mock invalid JSON response.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockInvalidJsonRequest() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], 'This is not JSON.'),
        ]);
    }

    /**
     * Mock "204 No Content" request.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockNoContentRequest() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(204, [], null),
        ]);
    }

    /**
     * Mock "404 Not Found" request.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockNotFoundRequest() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(404, [], null),
        ]);
    }

    /**
     * Mock "500 Internal Server Error" request.
     *
     * @return \GuzzleHttp\Client
     */
    private function mockInternalErrorRequest() : GuzzleClient
    {
        return $this->createMockedGuzzleClient([
            new GuzzleResponse(500, [], null),
        ]);
    }
}
