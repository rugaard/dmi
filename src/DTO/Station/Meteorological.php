<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Station;

use Rugaard\DMI\DTO\Station;
use Rugaard\DMI\Support\WMO;

/**
 * Class Meteorological.
 *
 * @package Rugaard\DMI\DTO\Station
 */
class Meteorological extends Station
{
    /**
     * List of measurements station supports.
     *
     * @var array
     */
    protected array $supportedMeasurements = [];

    /**
     * Station's height in meters above sea level.
     *
     * @var float|null
     */
    protected ?float $stationHeight;

    /**
     * Station's height of barometer in meters above sea level.
     *
     * @var float|null
     */
    protected ?float $barometerHeight;

    /**
     * World Meteorological Organization details.
     *
     * @var \Rugaard\DMI\Support\WMO|null
     */
    protected ?WMO $wmo;

    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        parent::parse($data);

        $this->setSupportedMeasurements($data['properties']['parameterId']);

        // Support for optional station's height.
        if (isset($data['properties']['stationHeight'])) {
            $this->setStationHeight($data['properties']['stationHeight']);
        }

        // Support for the optional station's barometer height.
        if (isset($data['properties']['barometerHeight'])) {
            $this->setBarometerHeight($data['properties']['barometerHeight']);
        }

        // Support for optional WMO details.
        if (isset($data['properties']['regionId']) || isset($data['properties']['wmoStationId']) || isset($data['properties']['wmoCountryCode'])) {
            $this->setWmo(new WMO(
                $data['properties']['wmoStationId'],
                $data['properties']['regionId'],
                $data['properties']['wmoCountryCode']
            ));
        }
    }

    /**
     * Set which measurements station supports.
     *
     * @param array $supportedMeasurements
     * @return $this
     */
    public function setSupportedMeasurements(array $supportedMeasurements): self
    {
        $this->supportedMeasurements = $supportedMeasurements;
        return $this;
    }

    /**
     * Get which measurements station supports.
     *
     * @return array|null
     */
    public function getSupportedMeasurements():? array
    {
        return $this->supportedMeasurements;
    }

    /**
     * Set station's height in meters above sea level.
     *
     * @param int|null $stationHeight
     * @return $this
     */
    public function setStationHeight(?float $stationHeight): self
    {
        $this->stationHeight = $stationHeight;
        return $this;
    }

    /**
     * Get station's height in meters above sea level.
     *
     * @return float|null
     */
    public function getStationHeight():? float
    {
        return $this->stationHeight;
    }

    /**
     * Set station's height of barometer in meters above sea level.
     *
     * @param float|null $barometerHeight
     * @return $this
     */
    public function setBarometerHeight(?float $barometerHeight): self
    {
        $this->barometerHeight = $barometerHeight;
        return $this;
    }

    /**
     * Get station's height of barometer in meters above sea level.
     *
     * @return float|null
     */
    public function getBarometerHeight():? float
    {
        return $this->barometerHeight;
    }

    /**
     * Set WMO details.
     *
     * @param \Rugaard\DMI\Support\WMO $wmo
     * @return $this
     */
    public function setWmo(WMO $wmo): self
    {
        $this->wmo = $wmo;
        return $this;
    }

    /**
     * Get WMO details.
     *
     * @return \Rugaard\DMI\Support\WMO|null
     */
    public function getWmo():? WMO
    {
        return $this->wmo;
    }
}
