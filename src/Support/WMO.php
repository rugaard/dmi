<?php
declare(strict_types=1);

namespace Rugaard\DMI\Support;

/**
 * Class WMO.
 *
 * @package Rugaard\DMI\Support
 */
class WMO
{
    /**
     * WMO station ID.
     *
     * @var string|null
     */
    protected ?string $stationId;

    /**
     * WMO region ID.
     *
     * @var string|null
     */
    protected ?string $regionId;

    /**
     * WMO country code.
     *
     * @var string|null
     */
    protected ?string $countryCode;

    /**
     * WMO constructor.
     *
     * @param string|null $stationId
     * @param string|null $regionId
     * @param string|null $countryCode
     */
    public function __construct(?string $stationId, ?string $regionId, ?string $countryCode)
    {
        $this->setStationId($stationId)
             ->setRegionId($regionId)
             ->setCountryCode($countryCode);
    }

    /**
     * Set station ID.
     *
     * @param string|null $stationId
     * @return $this
     */
    public function setStationId(?string $stationId): self
    {
        $this->stationId = $stationId;
        return $this;
    }

    /**
     * Get station ID.
     *
     * @return string|null
     */
    public function getStationId():? string
    {
        return $this->stationId;
    }

    /**
     * Set region ID.
     *
     * @param string|null $regionId
     * @return $this
     */
    public function setRegionId(?string $regionId): self
    {
        $this->regionId = $regionId;
        return $this;
    }

    /**
     * Get region ID.
     *
     * @return string|null
     */
    public function getRegionId():? string
    {
        return $this->regionId;
    }

    /**
     * Set country code.
     *
     * @param string|null $countryCode
     * @return $this
     */
    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * Get country code.
     *
     * @return string|null
     */
    public function getCountryCode():? string
    {
        return $this->countryCode;
    }
}
