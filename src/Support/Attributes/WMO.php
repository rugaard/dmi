<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

/**
 * Trait WMO.
 */
trait WMO
{
    /**
     * WMO region ID.
     *
     * @var int|null
     */
    public ?int $wmoRegionId;

    /**
     * WMO country code.
     *
     * @var string|null
     */
    public ?string $wmoCountryCode;

    /**
     * WMO station ID.
     *
     * @var string|null
     */
    public ?string $wmoStationId;

    /**
     * Set WMO region ID.
     *
     * @param string|null $regionId
     * @return $this
     */
    public function setRegionId(?string $regionId): self
    {
        $this->wmoRegionId = $regionId !== null ? (int) $regionId : null;
        return $this;
    }
}
