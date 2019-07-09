<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\DTO\Forecast\Current;
use Rugaard\DMI\DTO\Forecast\Day;
use Rugaard\DMI\DTO\Forecast\Hour;
use Rugaard\DMI\DTO\Forecast\Text;
use Rugaard\DMI\DTO\Measurements\Precipitation;
use Rugaard\DMI\DTO\Measurements\Temperature;
use Rugaard\DMI\DTO\Measurements\Wind;
use Rugaard\DMI\DTO\Measurements\Wind\Direction;
use Rugaard\DMI\DTO\Measurements\Wind\Gust;
use Rugaard\DMI\DTO\Measurements\Wind\Speed;
use Tightenco\Collect\Support\Collection;

/**
 * Class Location
 *
 * @package Rugaard\DMI\DTO
 */
class Location extends AbstractDTO
{
    /**
     * ID of location.
     *
     * @var int|null
     */
    protected $id;

    /**
     * City of location.
     *
     * @var string|null
     */
    protected $city;

    /**
     * Municipality of location.
     *
     * @var string|null
     */
    protected $municipality;

    /**
     * Region of location.
     *
     * @var string|null
     */
    protected $region;

    /**
     * Country of location.
     *
     * @var string|null
     */
    protected $country;

    /**
     * Latitude coordinate of location.
     *
     * @var float|null
     */
    protected $latitude;

    /**
     * Longitude coordinate of location.
     *
     * @var float|null
     */
    protected $longitude;

    /**
     * Timestamp of last update.
     *
     * @var \DateTime|null
     */
    protected $lastUpdate;

    /**
     * Timestamp of today's sunrise.
     *
     * @var \DateTime|null
     */
    protected $sunrise;

    /**
     * Timestamp of today's sunset.
     *
     * @var \DateTime|null
     */
    protected $sunset;

    /**
     * Array of forecasts (ie. hourly and daily).
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $forecasts;

    /**
     * Location constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Make sure forecast is a Collection.
        $this->forecasts = Collection::make();

        parent::__construct($data);
    }

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data): void
    {
        // Use timezone, if available.
        // Otherwise use "Europe/Copenhagen" as fallback.
        $timezone = new DateTimeZone($data['timezone'] ?? 'Europe/Copenhagen');

        $this->setId((int) $data['id'])
             ->setCity($data['city'])
             ->setCountry($data['country'])
             ->setLatitude((float) $data['latitude'])
             ->setLongitude((float) $data['longitude'])
             ->setLastUpdate($data['lastupdate'], $timezone)
             ->setSunrise($data['sunrise'], $timezone)
             ->setSunset($data['sunset'], $timezone)
             ->setCurrentlyForecast($data['timeserie'][0], $timezone)
             ->setHourlyForecast($data['timeserie'], $timezone)
             ->setDailyForecast($data['timeserie'], $timezone);
    }

    /**
     * Parse regional data and forecast.
     *
     * @param  array $data
     * @return void
     */
    public function parseRegional(array $data) : void
    {
        if (empty($data)) {
            return;
        }

        // Set municipality and regional.
        $this->setMunicipality($data['municipality'])->setRegion($data['regiondata'][0]['name']);

        // Get regional forecast.
        $regionalForecast = $data['regiondata'][0]['products'][0];

        // Decode nested XML.
        $regionalForecast['text'] = (array) simplexml_load_string($regionalForecast['text']);

        // Extract title and text from decoded XML.
        $title = (array) array_shift($regionalForecast['text']);
        $text = (array) array_pop($regionalForecast['text']);

        // Add regional forecast.
        $this->forecasts->put('regional', new Text([
            'title' => (string) $title['text'],
            'text' => (string) ((array) array_pop($text))['text'],
            'date' => (string) ((array) $regionalForecast['text']['dato'])['text'],
            'validity' => (string) ((array) $regionalForecast['text']['reggyld'])['text'],
            'timestamp' => $regionalForecast['timestamp']
        ]));
    }

    /**
     * Parse warnings.
     *
     * @param  array $data
     * @return void
     */
    public function parseWarnings(array $data) : void
    {
        if (empty($data['warnings'])) {
            return;
        }

        // Convert hourly warnings to a Collection.
        $hourlyWarnings = Collection::make($data['warnings'])->map(function ($item) {
            return Collection::make($item);
        });

        // Check if there is any warning for the current forecast.
        // If there is, parse them and add them to it.
        if (($currentForecastWarning = $hourlyWarnings->where('time', '=', $this->getCurrentlyForecast()->getTimestamp()->format('U') * 1000)->first()) !== null) {
            $warnings = Collection::make();
            foreach ($currentForecastWarning['warning_list'] as $warning) {
                $warnings->push(
                    (new Warning)
                        ->setTitle($warning['title'])
                        ->setDescription($warning['text'])
                        ->setNote($warning['cause'])
                        ->setArea($warning['warning_area'])
                        ->setType(strtolower($warning['group']))
                        ->setSeverity($warning['type'])
                );
            }
            $this->getCurrentlyForecast()->setWarnings($warnings);
        }

        // Loop through each hourly forecast
        // and add any warnings within that specific hour.
        $this->getHourlyForecast()->transform(function ($hour) use ($hourlyWarnings) {
            /* @var $hour \Rugaard\DMI\DTO\Forecast\Hour */
            $currentHourWarning = $hourlyWarnings->where('time', '=', $hour->getTimestamp()->format('U') * 1000)->first();
            if ($currentHourWarning === null) {
                return $hour;
            }

            $warnings = Collection::make();
            foreach ($currentHourWarning['warning_list'] as $warning) {
                $warnings->push(
                    (new Warning)
                    ->setTitle($warning['title'])
                    ->setDescription($warning['text'])
                    ->setNote($warning['cause'])
                    ->setArea($warning['warning_area'])
                    ->setType(strtolower($warning['group']))
                    ->setSeverity($warning['type'])
                );
            }

            return $hour->setWarnings($warnings);
        });

        // Convert daily warnings to a Collection.
        $dailyWarnings = Collection::make($data['locationWarnings']);

        // Loop through each daily forecast
        // and add any warnings within that specific day.
        $this->getDailyForecast()->transform(function ($day) use ($dailyWarnings) {
            /* @var $day \Rugaard\DMI\DTO\Forecast\Day */

            // Collection of warnings.
            $warnings = Collection::make();
            $dailyWarnings->each(function ($warning) use ($day, &$warnings) {
                // Get current day's date.
                $currentDay = $day->getTimeStamp()->format('Ymd');

                // Convert validity timestamps to DateTime objects.
                $validFrom = DateTime::createFromFormat('U', (string) ($warning['validFrom'] / 1000))->format('Ymd');
                $validTo = DateTime::createFromFormat('U', (string) ($warning['validTo'] / 1000))->format('Ymd');

                // Check if warning is valid during current day.
                if ($currentDay === $validFrom || $currentDay === $validTo) {
                    $warnings->push(new Warning($warning));
                }
            });

            if ($warnings->isNotEmpty()) {
                $day->setWarnings($warnings);
            }

            return $day;
        });
    }

    /**
     * Set location ID.
     *
     * @param  int $id
     * @return $this
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
     * Set city name.
     *
     * @param  string $city
     * @return $this
     */
    public function setCity(string $city) : self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city name.
     *
     * @return string|null
     */
    public function getCity() :? string
    {
        return $this->city;
    }

    /**
     * Set municipality name.
     *
     * @param  string $municipality
     * @return $this
     */
    public function setMunicipality(string $municipality) : self
    {
        $this->municipality = $municipality;
        return $this;
    }

    /**
     * Get municipality name.
     *
     * @return string|null
     */
    public function getMunicipality() :? string
    {
        return $this->municipality;
    }

    /**
     * Set region name.
     *
     * @param  string $region
     * @return $this
     */
    public function setRegion(string $region) : self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region name.
     *
     * @return string|null
     */
    public function getRegion() :? string
    {
        return $this->region;
    }

    /**
     * Set country name.
     *
     * @param  string $country
     * @return $this
     */
    public function setCountry(string $country) : self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country name.
     *
     * @return string|null
     */
    public function getCountry() :? string
    {
        return $this->country;
    }

    /**
     * Set latitude coordinate.
     *
     * @param  float $latitude
     * @return $this
     */
    public function setLatitude(float $latitude) : self
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get latitude coordinate.
     *
     * @return float|null
     */
    public function getLatitude() :? float
    {
        return $this->latitude;
    }

    /**
     * Set longitude coordinate.
     *
     * @param  float $longitude
     * @return $this
     */
    public function setLongitude(float $longitude) : self
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get longitude coordinate.
     *
     * @return float|null
     */
    public function getLongitude() :? float
    {
        return $this->longitude;
    }

    /**
     * Set last update timestamp.
     *
     * @param  string             $timestamp
     * @param  \DateTimeZone|null $timezone
     * @return $this
     */
    public function setLastUpdate(string $timestamp, ?DateTimeZone $timezone = null) : self
    {
        $this->lastUpdate = DateTime::createFromFormat('YmdHis', $timestamp, $timezone);
        return $this;
    }

    /**
     * Get last update timestamp.
     *
     * @return \DateTime|null
     */
    public function getLastUpdate() :? DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * Set today's sunrise timestamp.
     *
     * @param  string             $timestamp
     * @param  \DateTimeZone|null $timezone
     * @return $this
     */
    public function setSunrise(string $timestamp, ?DateTimeZone $timezone = null) : self
    {
        $this->sunrise = DateTime::createFromFormat('Hi', strlen($timestamp) < 4 ? '0' . $timestamp : $timestamp, $timezone);
        return $this;
    }

    /**
     * Get today's sunrise timestamp.
     *
     * @return \DateTime|null
     */
    public function getSunrise() :? DateTime
    {
        return $this->sunrise;
    }

    /**
     * Set today's sunset timestamp.
     *
     * @param  string             $timestamp
     * @param  \DateTimeZone|null $timezone
     * @return $this
     */
    public function setSunset(string $timestamp, ?DateTimeZone $timezone = null) : self
    {
        $this->sunset = DateTime::createFromFormat('Hi', strlen($timestamp) < 4 ? '0' . $timestamp : $timestamp, $timezone);
        return $this;
    }

    /**
     * Get today's sunset timestamp.
     *
     * @return \DateTime|null
     */
    public function getSunset() :? DateTime
    {
        return $this->sunset;
    }

    /**
     * Get forecasts collection.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getForecasts() :? Collection
    {
        return $this->forecasts;
    }

    /**
     * Get regional forecast.
     *
     * @return \Rugaard\DMI\DTO\Forecast\Text|null
     */
    public function getRegionalForecast() :? Text
    {
        return $this->forecasts->get('regional');
    }

    /**
     * Set currently forecast.
     *
     * @param  array              $currentHour
     * @param  \DateTimeZone|null $timezone
     * @return $this
     */
    public function setCurrentlyForecast(array $currentHour, ?DateTimeZone $timezone = null) : self
    {
        $this->forecasts->put('currently', new Current(array_merge($currentHour, [
            'timezone' => $timezone->getName() ?? null
        ])));
        return $this;
    }

    /**
     * Get currently forecast.
     *
     * @return \Rugaard\DMI\DTO\Forecast\Current|null
     */
    public function getCurrentlyForecast() :? Current
    {
        return $this->forecasts->get('currently');
    }

    /**
     * Set hourly forecast.
     *
     * @param  array              $hours
     * @param  \DateTimeZone|null $timezone
     * @return $this
     */
    public function setHourlyForecast(array $hours, ?DateTimeZone $timezone = null) : self
    {
        // Container.
        $forecast = Collection::make();

        foreach ($hours as $hour) {
            $forecast->put(
                DateTime::createFromFormat('YmdHis', $hour['time'], $timezone)->format('YmdHis'),
                new Hour(array_merge($hour, [
                    'timezone' => $timezone->getName() ?? null
                ]))
            );
        }

        $this->forecasts->put('hourly', $forecast);
        return $this;
    }

    /**
     * Get hourly forecast.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getHourlyForecast() :? Collection
    {
        return $this->forecasts->get('hourly');
    }

    /**
     * Set daily forecast.
     *
     * @param  array              $hours
     * @param  \DateTimeZone|null $timezone
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function setDailyForecast(array $hours, ?DateTimeZone $timezone = null) :? Location
    {
        // Container
        $forecast = Collection::make();

        foreach ($hours as $hour) {
            // Parse hour.
            $currentHour = new Hour($hour);

            // Determine date of hour.
            $dateOfHour = (int) $currentHour->getTimestamp()->format('Ymd');

            // If current hour is a new day,
            // we'll add the new day to our forecast.
            if (!$forecast->has($dateOfHour)) {
                // Add new date to forecast.
                $forecast->put($dateOfHour, Collection::make([
                    'icon' => Collection::make(),
                    'temperature' => Collection::make([
                        'value' => Collection::make(),
                        'lowest' => Collection::make(),
                        'highest' => Collection::make(),
                    ]),
                    'precipitation' => Collection::make([
                        'types' => Collection::make(),
                        'amount' => Collection::make([
                            'value' => Collection::make(),
                            'lowest' => Collection::make(),
                            'highest' => Collection::make()
                        ]),
                    ]),
                    'humidity' => Collection::make(),
                    'pressure' => Collection::make(),
                    'wind' => Collection::make([
                        'speed' =>  Collection::make([
                            'value' => Collection::make(),
                            'lowest' => Collection::make(),
                            'highest' => Collection::make(),
                        ]),
                        'direction' => Collection::make(),
                        'degrees' => Collection::make(),
                        'gust' => Collection::make(),
                    ]),
                    'visibility' => Collection::make(),
                    'hours' => Collection::make()
                ]));
            }

            // We'll go through each hour and add all it's measurements
            // to our current forecast date. This will be used later
            // to calculate an average of each measurement for the entire day.
            $forecast->get($dateOfHour)->transform(function ($item, $key) use ($currentHour) {
                switch ($key) {
                    case 'hours':
                        // Add current hour to the hour collection.
                        $item->push($currentHour);
                        break;
                    case 'icon':
                        // Get icon of current hour.
                        $hourIcon = str_replace('-night', '', $currentHour->getIcon());

                        // Increment number of types icon
                        // has been present during the day.
                        if (!empty($hourIcon)) {
                            $item->put($hourIcon, $item->has($hourIcon) ? $item->get($hourIcon) + 1 : 1);
                        }
                        break;
                    case 'temperature':
                        // Get precipitation data of current hour.
                        $hourTemperature = $currentHour->getTemperature();

                        if ($hourTemperature !== null) {
                            // Push precipitation amount to collection.
                            $item->get('value')->push($hourTemperature->getValue());
                            $item->get('lowest')->push($hourTemperature->getLowestValue());
                            $item->get('highest')->push($hourTemperature->getHighestValue());
                        }
                        break;
                    case 'precipitation':
                        // Get precipitation data of current hour.
                        $hourPrecipitation = $currentHour->getPrecipitation();

                        // Push precipitation values and type to collection,
                        // so we can calculate an average later.
                        if ($hourPrecipitation !== null) {
                            // Push precipitation amount to collection.
                            $item->get('amount')['value']->push($hourPrecipitation->getValue());
                            $item->get('amount')['lowest']->push($hourPrecipitation->getLowestValue());
                            $item->get('amount')['highest']->push($hourPrecipitation->getHighestValue());

                            // Increment number of times
                            // precipitation type has been present during the day.
                            $item->get('types')->put($hourPrecipitation->getType(), $item->has($hourPrecipitation->getType()) ? $item->get($hourPrecipitation->getType()) + 1 : 1);
                        }
                        break;
                    case 'wind':
                        // Get wind data of current hour.
                        $hourWind = $currentHour->getWind();

                        // Push wind values and type to collection,
                        // so we can calculate an average later.
                        if ($hourWind !== null) {
                            // Push wind speed to collection.
                            $item->get('speed')['value']->push($hourWind->getSpeed()->getValue());
                            $item->get('speed')['lowest']->push($hourWind->getSpeed()->getLowestValue());
                            $item->get('speed')['highest']->push($hourWind->getSpeed()->getHighestValue());

                            // Push wind gust to collection.
                            $item->get('gust')->push($hourWind->getGust()->getValue());

                            // Push wind direction to collection.
                            $hourWindDirection = $hourWind->getDirection();
                            if ($hourWindDirection !== null) {
                                $item->get('direction')->put($hourWindDirection->getDirection(), $item->has($hourWindDirection->getDirection()) ? $item->get($hourWindDirection->getDirection()) + 1 : 1);
                                $item->get('degrees')->push($hourWindDirection->getDegrees());
                            }
                        }
                        break;
                    default:
                        // Get value for current key of current hour.
                        $hourValue = $currentHour->{'get' . ucfirst($key)}()->getValue();

                        // Push value to it's collection,
                        // so we can calculate the average later.
                        if (!empty($hourValue)) {
                            $item->push($hourValue);
                        }
                }
                return $item;
            });
        }

        // After having completed all the data collecting for each day
        // we'll loop through each day, and calculate the different
        // measurements average values.
        $forecast->transform(function ($item, $key) use ($timezone) {
            $day = new Day([
                'time' => $key . '120000',
                'timezone' => $timezone->getName(),
                'humidity' => $item->get('humidity')->average(),
                'pressure' => $item->get('pressure')->average(),
                'visibility' => $item->get('visibility')->average(),
            ]);

            // Set icon.
            $day->setIcon($item->get('icon')->sort()->keys()->last());

            // Set temperature.
            $day->setTemperature((new Temperature)
                ->setValue($item->get('temperature')->get('value')->average() ?? 0.0)
                ->setLowestValue($item->get('temperature')->get('lowest')->average() ?? 0.0)
                ->setHighestValue($item->get('temperature')->get('highest')->average() ?? 0.0)
            );

            // Set precipitation.
            $day->setPrecipitation((new Precipitation)
                ->setType($item->get('precipitation')->get('types')->sort()->keys()->last())
                ->setValue($item->get('precipitation')->get('amount')->get('value')->average() ?? 0.0)
                ->setLowestValue($item->get('precipitation')->get('amount')->get('lowest')->average() ?? 0.0)
                ->setHighestValue($item->get('precipitation')->get('amount')->get('highest')->average() ?? 0.0)
            );

            // Set wind.
            $day->setWind((new Wind)
                ->setSpeed((new Speed)
                    ->setValue($item->get('wind')->get('speed')->get('value')->average() ?? 0.0)
                    ->setLowestValue($item->get('wind')->get('speed')->get('lowest')->average() ?? 0.0)
                    ->setHighestValue($item->get('wind')->get('speed')->get('highest')->average() ?? 0.0)
                )
                ->setDirection((new Direction)
                    ->setDegreesAndDirection($item->get('wind')->only('degrees')->transform(function ($degrees) {
                        $sinSum = 0;
                        $cosSum = 0;
                        $degrees->each(function ($value) use (&$sinSum, &$cosSum) {
                            $sinSum += sin(deg2rad($value));
                            $cosSum += cos(deg2rad($value));
                        });
                        return fmod(rad2deg(atan2($sinSum, $cosSum)) + 360, 360);
                    })->first() ?? 0)
                )
                ->setGust((new Gust)->setValue($item->get('wind')->get('gust')->average() ?? 0.0))
            );
            return $day;
        });

        $this->forecasts->put('daily', $forecast);
        return $this;
    }

    /**
     * Get daily forecast.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getDailyForecast() :? Collection
    {
        return $this->forecasts->get('daily');
    }
}