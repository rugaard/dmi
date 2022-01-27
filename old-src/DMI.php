<?php
declare(strict_types=1);

namespace Rugaard\OldDMI;

use DateTime;
use DateTimeZone;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\Exception\GuzzleException;
use Rugaard\OldDMI\DTO\Forecast\Text;
use Rugaard\OldDMI\DTO\Location;
use Rugaard\OldDMI\DTO\SeaStation;
use Rugaard\OldDMI\Endpoints\Archive;
use Rugaard\OldDMI\Endpoints\Forecast;
use Rugaard\OldDMI\Endpoints\Pollen;
use Rugaard\OldDMI\Endpoints\Search;
use Rugaard\OldDMI\Endpoints\SeaStations;
use Rugaard\OldDMI\Endpoints\SunTimes;
use Rugaard\OldDMI\Endpoints\UV;
use Rugaard\OldDMI\Endpoints\Warnings;
use Rugaard\OldDMI\Exceptions\ClientException;
use Rugaard\OldDMI\Exceptions\DMIException;
use Rugaard\OldDMI\Exceptions\ParsingFailedException;
use Rugaard\OldDMI\Exceptions\ServerException;
use Rugaard\OldDMI\Exceptions\RequestException;
use Rugaard\OldDMI\Support\Traits\Municipalities;
use Throwable;
use Tightenco\Collect\Support\Collection;

/**
 * Class DMI.
 *
 * @package Rugaard\OldDMI
 */
class DMI
{
    use Municipalities;

    /**
     * Base URL of "NinJo" web service.
     *
     * @const string
     */
    public const DMI_WS_BASE_URL_NINJO = 'https://www.dmi.dk/NinJo2DmiDk/ninjo2dmidk';

    /**
     * Base URL of "city weather" web service.
     *
     * @const string
     */
    public const DMI_WS_BASE_URL_CITY_WEATHER = 'https://www.dmi.dk/dmidk_byvejrWS/rest';

    /**
     * Base URL of "observing" web service.
     *
     * @const string
     */
    public const DMI_WS_BASE_URL_OBSERVER = 'https://www.dmi.dk/dmidk_obsWS/rest';

    /**
     * Base URL of "search" web service.
     *
     * @const string
     */
    public const DMI_WS_BASE_URL_SEARCH = 'https://www.dmi.dk/solr/city_core/select';

    /**
     * Client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Location ID.
     *
     * @var int
     */
    protected $id;

    /**
     * DMI constructor.
     *
     * @param int|null                         $defaultLocationId
     * @param \GuzzleHttp\ClientInterface|null $client
     */
    public function __construct(?int $defaultLocationId = null, ?ClientInterface $client = null)
    {
        if ($defaultLocationId !== null) {
            $this->setId($defaultLocationId);
        }

        if ($client !== null) {
            $this->setClient($client);
        }
    }

    /**
     * Search locations (City, POI etc.)
     *
     * @param  string $query
     * @param  int    $limit
     * @return \Rugaard\OldDMI\Endpoints\Search
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function search(string $query, int $limit = 20) : Search
    {
        try {
            // Request DMI API data.
            $data = $this->request(self::DMI_WS_BASE_URL_SEARCH . '?' . http_build_query([
                'q' => '(name:"' . $query . '" AND realm:1)^4 OR (name_ngram:"' . $query . '" AND realm:1)',
                'rows' => $limit,
                'sort' => 'score desc, realm desc, population desc',
                'wt' => 'json'
            ]));

            return new Search($data['response']['docs']);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get descriptive national forecast.
     *
     * @return \Rugaard\OldDMI\DTO\Forecast\Text
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function forecast() : Text
    {
        try {
            // Request DMI API data.
            $data = $this->request(self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/forecast/land/Danmark');

            // Extract forecast from data.
            $forecast = $data[0]['products'];

            // Decode nested XML.
            $forecast['text'] = (array) simplexml_load_string($forecast['text']);

            return new Text([
                'title' => 'Udsigt for hele Danmark',
                'text' => (string) ((array) $forecast['text']['udsigt'])['text'],
                'date' => (string) ((array) $forecast['text']['dato'])['text'],
                'validity' => (string) ((array) $forecast['text']['gyldighed'])['text'],
                'timestamp' => $forecast['timestamp']
            ]);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get extended (7 days) descriptive national forecast.
     *
     * @return \Rugaard\OldDMI\Endpoints\Forecast
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function extendedForecast() : Forecast
    {
        try {
            // Request DMI API data.
            $data = $this->request(self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/forecast/land7/Danmark');

            // Extract forecast from data.
            $forecast = $data[0]['products'];

            // Decode nested XML.
            $forecast['text'] = simplexml_load_string($forecast['text']);

            return new Forecast([
                'title' => (string) $forecast['text']->overskriftsyvdgn->text,
                'text' => (string) $forecast['text']->oversigt->text,
                'date' => (string) $forecast['text']->dato->text,
                'uncertainty' => trim((string) $forecast['text']->usikkerhed->text),
                'timestamp' => $forecast['timestamp'],
                'days' => [
                    $forecast['text']->dagnavnnul,
                    $forecast['text']->dagnavnet,
                    $forecast['text']->dagnavnto,
                    $forecast['text']->dagnavntre,
                    $forecast['text']->dagnavnfire,
                    $forecast['text']->dagnavnfem,
                    $forecast['text']->dagnavnsekssyv,
                ]
            ]);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get location by ID.
     *
     * @param  int|null $id
     * @param  bool     $includeRegional
     * @param  bool     $includeWarnings
     * @return \Rugaard\OldDMI\DTO\Location
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function location(?int $id = null, $includeRegional = true, bool $includeWarnings = true) : Location
    {
        try {
            // Request DMI API data.
            $data = $this->requestNinJo('llj', [
                'id' => $id ?? $this->getId(),
            ]);

            // Parse data.
            $location = new Location($data);

            // Include regional data and forecast.
            // NOTE: This will make an additional request to DMI.
            if ($includeRegional) {
                try {
                    // Request descriptive forecast.
                    $regionalData = $this->request(sprintf(
                        self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/%d',
                        $location->getId()
                    ));

                    // Parse descriptive forecast.
                    $location->parseRegional($regionalData);
                } catch (Throwable $e) { /* Silent fail */ }
            }

            // Include warnings for location.
            // NOTE: This will make an additional request to DMI.
            if ($includeWarnings) {
                try {
                    $data = $this->requestWithLocationId(
                        self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/varsler/geonameid/%d',
                        $location->getId()
                    );

                    // Collection of warnings.
                    $location->parseWarnings($data);
                } catch (Throwable $e) { /* Silent fail */ }
            }

            return $location;
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get location by coordinate (aka. nearest weather station).
     *
     * @param  float $latitude
     * @param  float $longitude
     * @param  bool  $includeRegional
     * @param  bool  $includeWarnings
     * @return \Rugaard\OldDMI\DTO\Location
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function locationByCoordinate(float $latitude, float $longitude, bool $includeRegional = true, bool $includeWarnings = true) : Location
    {
        try {
            // Request DMI API.
            $data = $this->requestNinJo('llj', [
                'lat' => $latitude,
                'lon' => $longitude
            ]);

            // Parse data.
            $location = new Location($data);

            // Include regional data and forecast.
            // NOTE: This will make an additional request to DMI.
            if ($includeRegional) {
                try {
                    // Request descriptive forecast.
                    $regionalData = $this->request(sprintf(
                        self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/%d',
                        $location->getId()
                    ));

                    // Parse descriptive forecast.
                    $location->parseRegional($regionalData);
                } catch (Throwable $e) { /* Silent fail */ }
            }

            // Include warnings for location.
            // NOTE: This will make an additional request to DMI.
            if ($includeWarnings) {
                try {
                    $data = $this->requestWithLocationId(
                        self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/varsler/geonameid/%d',
                        $location->getId()
                    );

                    // Collection of warnings.
                    $location->parseWarnings($data);
                } catch (Throwable $e) { /* Silent fail */ }
            }

            return $location;
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get national warnings.
     *
     * @return \Rugaard\OldDMI\Endpoints\Warnings|null
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function warnings() :? Warnings
    {
        try {
            // Request DMI API.
            $data = $this->request(self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/warnings/overview/Danmark');

            // Parse data.
            return new Warnings($data);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get sun times.
     *
     * @param  int|null $id
     * @return \Rugaard\OldDMI\Endpoints\SunTimes
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function sunTimes(?int $id = null) : SunTimes
    {
        try {
            // Request DMI API.
            $data = $this->requestWithLocationId(
                self::DMI_WS_BASE_URL_CITY_WEATHER . '/sunUpDown/%d',
                $id ?? $this->getId()
            );

            // Parse data.
            return new SunTimes($data);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get UV index.
     *
     * @param  int|null $id
     * @return \Rugaard\OldDMI\Endpoints\UV
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function uv(?int $id = null) : UV
    {
        try {
            // Request DMI API.
            $data = $this->requestWithLocationId(
                self::DMI_WS_BASE_URL_CITY_WEATHER . '/sunUpDown/UV/%d',
                $id ?? $this->getId()
            );

            // Parse data.
            return new UV($data['UV']);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get national pollen measurements.
     *
     * @return \Rugaard\OldDMI\Endpoints\Pollen
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function pollen() : Pollen
    {
        try {
            // Request DMI API.
            $data = $this->request(self::DMI_WS_BASE_URL_CITY_WEATHER . '/texts/forecast/pollen/Danmark');

            // Parse data.
            return new Pollen($data[0]);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get active sea stations.
     *
     * @param  bool $withObservations
     * @param  bool $withForecast
     * @return \Rugaard\OldDMI\Endpoints\SeaStations
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function seaStations(bool $withObservations = false, bool $withForecast = false) : SeaStations
    {
        try {
            // Request DMI API.
            $data = $this->request(self::DMI_WS_BASE_URL_CITY_WEATHER . '/vandstand/active');

            // Parse data.
            $seaStations = new SeaStations($data);

            if ($withObservations === true || $withForecast === true) {
                // Collect all station ID's.
                $seaStationIds = $seaStations->getData()->map(function ($seaStation) {
                    /* @var $seaStation \Rugaard\OldDMI\DTO\SeaStation */
                    return $seaStation->getId();
                });

                // Include sea station observations.
                // NOTE: This will make an additional request to DMI.
                if ($withObservations === true) {
                    // Request DMI API for observations.
                    $observationsData = Collection::make($this->requestNinJo('odj', [
                        'stations' => $seaStationIds->implode(','),
                        'datatype' => 'obs'
                    ]));

                    $seaStations->getData()->each(function ($seaStation) use ($observationsData) {
                        /* @var $seaStation \Rugaard\OldDMI\DTO\SeaStation */

                        // Get observations by station ID.
                        $observations = $observationsData->where('stationId', '=', $seaStation->getId())->first();

                        // Convert timestamp to a DateTime object.
                        $lastUpdatedTimestamp = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string) $observations['generatedTime'], new DateTimeZone('Europe/Copenhagen'));

                        // Add observations to station.
                        $seaStation->setObservations(Collection::make([
                            'lastUpdated' => $lastUpdatedTimestamp,
                            'data' => Collection::make($observations['values'])->reject(function ($item) {
                                return empty($item);
                            })->map(function ($item) {
                                // Convert timestamp to a DateTime object.
                                $item['timestamp'] = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string) $item['time'], new DateTimeZone('Europe/Copenhagen'));
                                unset($item['time']);
                                return Collection::make($item);
                            })
                        ]));
                    });
                }

                // Include sea station forecast.
                // NOTE: This will make an additional request to DMI.
                if ($withForecast === true) {
                    // Request DMI API for forecast.
                    $forecastData = Collection::make($this->requestNinJo('odj', [
                        'stations' => $seaStationIds->implode(','),
                        'datatype' => 'flt'
                    ]));

                    $seaStations->getData()->each(function ($seaStation) use ($forecastData) {
                        /* @var $seaStation \Rugaard\OldDMI\DTO\SeaStation */
                        // Get forecast by station ID.
                        $forecast = $forecastData->where('stationId', '=', $seaStation->getId())->first();

                        // Convert timestamp to a DateTime object.
                        $lastUpdatedTimestamp = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string) $forecast['generatedTime'], new DateTimeZone('Europe/Copenhagen'));

                        // Add observations to station.
                        $seaStation->setForecast(Collection::make([
                            'lastUpdated' => $lastUpdatedTimestamp,
                            'data' => Collection::make($forecast['values'])->reject(function ($item) {
                                return empty($item);
                            })->map(function ($item) {
                                // Convert timestamp to a DateTime object.
                                $item['timestamp'] = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string) $item['time'], new DateTimeZone('Europe/Copenhagen'));
                                unset($item['time']);
                                return Collection::make($item);
                            })
                        ]));

                        return $seaStation;
                    });
                }
            }

            // Parse data.
            return $seaStations;
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get sea station by ID.
     *
     * @param  int  $stationId
     * @param  bool $withObservations
     * @param  bool $withForecast
     * @return \Rugaard\OldDMI\DTO\SeaStation|null
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function seaStation(int $stationId, bool $withObservations = false, bool $withForecast = false) :? SeaStation
    {
        // Get all active sea stations.
        $seaStations = $this->seaStations($withObservations, $withForecast)->getData();

        return $seaStations->first(function ($seaStation) use ($stationId) {
            /* @var $seaStation \Rugaard\OldDMI\DTO\SeaStation */
            return $seaStation->getId() === $stationId;
        });
    }

    /**
     * @param  string           $measurement
     * @param  string           $frequency
     * @param  \DateTime|string $period
     * @param  int|null         $municipalityId
     * @param  string           $country
     * @return \Rugaard\OldDMI\Endpoints\Archive
     * @throws \Rugaard\OldDMI\Exceptions\DMIException
     */
    public function archive(string $measurement, string $frequency, $period, ?int $municipalityId = null, string $country = 'DK') : Archive
    {
        // Validate required measurement.
        $supportedMeasurements = Collection::make(['temperature', 'precipitation', 'wind', 'wind-direction', 'humidity', 'pressure', 'sun', 'drought', 'lightning', 'snow']);
        if (!$supportedMeasurements->contains($measurement)) {
            throw new DMIException('Invalid measurement. Supported measurements are: "' . $supportedMeasurements->implode('", "') . '"', 400);
        }

        // Validate requested frequency..
        $supportedFrequencies = Collection::make(['hourly', 'daily', 'monthly', 'yearly']);
        if (!$supportedFrequencies->contains($frequency)) {
            throw new DMIException('Invalid frequency. Supported frequencies are: "' . $supportedFrequencies->implode('", "') . '"', 400);
        }

        // Validate municipality.
        if ($municipalityId !== null && !$this->getMunicipalities()->has($municipalityId)) {
            throw new DMIException('Invalid municipality ID. Check the documentation for a list of municipality ID\'s.', 400);
        }

        // Validate requested country.
        $supportedCountries = Collection::make(['DK' => 'Danmark', 'GL' => 'Grønland', 'FO' => 'Færøerne']);
        if (!$supportedCountries->has($country)) {
            throw new DMIException('Invalid country. Supported countries are: "' . $supportedCountries->keys()->implode('", "') . '"', 400);
        }

        // Validate requested time period.
        if (!($period instanceof DateTime)) {
            if ($frequency === 'yearly') {
                $period = DateTime::createFromFormat('Y-m-d H:i:s', $period . '-01-01 02:00:00', new DateTimeZone('Europe/Copenhagen'));
            } elseif ($frequency === 'monthly') {
                $period = DateTime::createFromFormat('Y-m-d H:i:s', $period . '-01 02:00:00', new DateTimeZone('Europe/Copenhagen'));
            } else {
                $period = DateTime::createFromFormat('Y-m-d H:i:s', $period . ' 02:00:00', new DateTimeZone('Europe/Copenhagen'));
            }

            if ($period === false) {
                throw new DMIException('Invalid time period provided. Provide either a DateTime object or a string in the format corresponding to the frequency.');
            }
        }

        // Convert measurement type to URL slug.
        switch ($measurement) {
            case 'wind-direction':
                $measurementSlug = 'winddir';
                break;
            case 'precipitation':
                $measurementSlug = 'precip';
                break;
            case 'sun':
                $measurementSlug = 'sunhours';
                break;
            default:
                $measurementSlug = $measurement;
        }

        // For some reason DMI has some inconsistency
        // in how their country naming works. This is a fix for that.
        if ($country === 'DK') {
            $country = 'danmark';
        }

        try {
            // Request DMI API.
            switch ($frequency) {
                case 'yearly':
                    $data = $this->request(sprintf(
                        self::DMI_WS_BASE_URL_OBSERVER . '/archive/%s/%s/%s/%s/%d/%d',
                        $frequency,
                        $country,
                        $measurementSlug,
                        $municipalityId !== null ? $this->getMunicipalities()->get($municipalityId) : 'Hele landet',
                        $period->format('Y') - 8,
                        $period->format('Y')
                    ));
                    break;
                case 'monthly':
                    $data = $this->request(sprintf(
                        self::DMI_WS_BASE_URL_OBSERVER . '/archive/%s/%s/%s/%s/%d',
                        $frequency,
                        $country,
                        $measurementSlug,
                        $municipalityId !== null ? $this->getMunicipalities()->get($municipalityId) : 'Hele landet',
                        $period->format('Y')
                    ));
                    break;
                case 'daily':
                    $data = $this->request(sprintf(
                        self::DMI_WS_BASE_URL_OBSERVER . '/archive/%s/%s/%s/%s/%d/%s',
                        $frequency,
                        $country,
                        $measurementSlug,
                        $municipalityId !== null ? $this->getMunicipalities()->get($municipalityId) : 'Hele landet',
                        $period->format('Y'),
                        getDanishMonthNameByMonthNo((int) $period->format('n'))
                    ));
                    break;
                default:
                    $data = $this->request(sprintf(
                        self::DMI_WS_BASE_URL_OBSERVER . '/archive/%s/%s/%s/%s/%d/%s/%d',
                        $frequency,
                        $country,
                        $measurementSlug,
                        $municipalityId !== null ? $this->getMunicipalities()->get($municipalityId) : 'Hele landet',
                        $period->format('Y'),
                        getDanishMonthNameByMonthNo((int) $period->format('n')),
                        $period->format('d')
                    ));
            }

            // Parse data.
            return new Archive($measurement, $frequency, $period, $data);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Send request to DMI's NinJo web service.
     *
     * @param  string $command
     * @param  array  $parameters
     * @return array
     * @throws \Rugaard\OldDMI\Exceptions\ParsingFailedException
     */
    private function requestNinJo(string $command, array $parameters) : array
    {
        return $this->request(sprintf(
            '%s?cmd=%s&%s',
            self::DMI_WS_BASE_URL_NINJO,
            $command,
            http_build_query($parameters)
        ));
    }

    /**
     * Send request to DMI's city web service.
     *
     * @param  string $url
     * @param  int    $locationId
     * @return array
     * @throws \Rugaard\OldDMI\Exceptions\ParsingFailedException
     * @throws \Rugaard\OldDMI\Exceptions\ServerException
     * @throws \Rugaard\OldDMI\Exceptions\ClientException
     * @throws \Rugaard\OldDMI\Exceptions\RequestException
     */
    private function requestWithLocationId(string $url, int $locationId) : array
    {
        return $this->request(sprintf($url, $locationId));
    }

    /**
     * Send request to DMI.
     *
     * @param  string $url
     * @return array
     * @throws \Rugaard\OldDMI\Exceptions\ParsingFailedException
     * @throws \Rugaard\OldDMI\Exceptions\ServerException
     * @throws \Rugaard\OldDMI\Exceptions\ClientException
     * @throws \Rugaard\OldDMI\Exceptions\RequestException
     */
    private function request(string $url) : array
    {
        // If no client instance has been set,
        // we'll setup a default one with gzip enabled.
        if (!$this->hasClient()) {
            $this->defaultClient();
        }

        try {
            // Send request.
            /* @var $response \Psr\Http\Message\ResponseInterface */
            $response = $this->getClient()->request('get', $url);

            // If response is being returned with "204 No Content"
            // we'll just return an empty array.
            if ($response->getStatusCode() === 204) {
                return [];
            }

            // Extract body from response.
            $body = (string) $response->getBody();

            // JSON Decode response.
            $data = json_decode($body, true);

            // Make sure that the decoding procedure didn't fail.
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ParsingFailedException(sprintf('Could not JSON decode response. Reason: %s.', json_last_error_msg()), 400);
            }

            return $data;
        } catch (GuzzleServerException $e) {
            throw new ServerException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
        } catch (GuzzleClientException $e) {
            throw new ClientException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
        } catch (GuzzleException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Set location ID.
     *
     * @param  int $id
     * @return \Rugaard\OldDMI\Client
     */
    public function setId(int $id) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get location ID.
     *
     * @return int|null
     */
    public function getId() :? int
    {
        return $this->id;
    }

    /**
     * Set a default client instance.
     *
     * @return void
     */
    protected function defaultClient() : void
    {
        $this->setClient(new GuzzleClient([
            'headers' => [
                'Accept-Encoding' => 'gzip',
            ]
        ]));
    }

    /**
     * Check that we have a client instance.
     *
     * @return bool
     */
    public function hasClient() : bool
    {
        return $this->getClient() !== null;
    }

    /**
     * Set client instance.
     *
     * @param  \GuzzleHttp\ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client) : self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get client instance.
     *
     * @return \GuzzleHttp\ClientInterface|null
     */
    public function getClient() :? ClientInterface
    {
        return $this->client;
    }
}
