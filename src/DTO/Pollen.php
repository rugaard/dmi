<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Tightenco\Collect\Support\Collection;

/**
 * Class Pollen
 *
 * @package Rugaard\DMI\DTO
 */
class Pollen extends AbstractDTO
{
    /**
     * Region name.
     *
     * @var string|null
     */
    protected $name;

    /**
     * Pollen readings.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $readings;

    /**
     * Pollen forecast.
     *
     * @var string|null
     */
    protected $forecast;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setName($data['name']);

        if (isset($data['forecast'])) {
            $this->setForecast($data['forecast']);
        }

        if (isset($data['readings']) && $data['readings']->count() > 0) {
            $this->setReadings(Collection::make($data['readings']->xpath('reading'))->map(function ($data) {
                // Convert to array.
                $data = (array) $data;

                if (in_array($data['name'], ['Alternaria', 'Cladosporium'])) {
                    $data['level'] = $this->determinePollenLevelByText($data['value']);
                    $data['value'] = null;
                } else {
                    $data['value'] = is_numeric($data['value']) ? (int)$data['value'] : 0;
                    $data['level'] = $this->getPollenLevel($data['name'], $data['value']);
                }

                return Collection::make($data);
            }));
        }
    }

    /**
     * Set region name.
     *
     * @param  string $name
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get region name.
     *
     * @return string|null
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set forecast.
     *
     * @param  string $forecast
     * @return $this
     */
    public function setForecast(string $forecast) : self
    {
        $this->forecast = $forecast;
        return $this;
    }

    /**
     * Get forecast.
     *
     * @return string|null
     */
    public function getForecast() :? string
    {
        return $this->forecast;
    }

    /**
     * Set pollen readings.
     *
     * @param  \Tightenco\Collect\Support\Collection $readings
     * @return $this
     */
    public function setReadings(Collection $readings) : self
    {
        $this->readings = $readings;
        return $this;
    }

    /**
     * Get pollen readings.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getReadings() :? Collection
    {
        return $this->readings;
    }

    /**
     * Get pollen level.
     *
     * @param  string     $name
     * @param  int|string $value
     * @return string|null
     */
    protected function getPollenLevel(string $name, $value) :? string
    {
        switch ($name) {
            case 'Birk':
                return $this->determinePollenLevel($value, 100, 30);
            case 'Bynke':
                return $this->determinePollenLevel($value, 50, 10);
            case 'El':
                return $this->determinePollenLevel($value, 50, 10);
            case 'Elm':
                return $this->determinePollenLevel($value, 50, 10);
            case 'Græs':
                return $this->determinePollenLevel($value, 50, 10);
            case 'Hassel':
                return $this->determinePollenLevel($value, 15, 5);
        }
        return null;
    }

    /**
     * Determine pollen level.
     *
     * @param  int $value
     * @param  int $highValue
     * @param  int $moderateValue
     * @return string|null
     */
    protected function determinePollenLevel(int $value, int $highValue, int $moderateValue) :? string
    {
        if ($value <= 0) {
            return null;
        }

        if ($value > $highValue) {
            return 'High';
        }

        if ($value <= $highValue && $value >= $moderateValue) {
            return 'Moderate';
        }

        return 'Low';
    }

    /**
     * Determine pollen level by text.
     *
     * @param  string $value
     * @return string|null
     */
    protected function determinePollenLevelByText(string $value) :? string
    {
        switch ($value) {
            case 'Højt':
                return 'High';
                break;
            case 'Moderat':
                return 'Moderate';
                break;
            case 'Lavt':
                return 'Low';
            default:
                return null;
        }
    }
}
