<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Stations;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Station;
use Rugaard\DMI\Enums\Meteorological\Parameter;
use Rugaard\DMI\Enums\Meteorological\StationType;
use Rugaard\DMI\Support\Attributes\ActiveStatus as HasActiveStatus;
use Rugaard\DMI\Support\Attributes\OperationalPeriod as HasOperationalPeriod;
use Rugaard\DMI\Support\Attributes\UpdatedTimestamp as HasUpdatedTimestamp;
use Rugaard\DMI\Support\Attributes\ValidityPeriod as HasValidityPeriod;
use Rugaard\DMI\Support\Attributes\WMO as HasWMOInfo;

/**
 * Class Meteorological.
 */
class Meteorological extends Station
{
    use HasActiveStatus, HasOperationalPeriod, HasUpdatedTimestamp, HasValidityPeriod, HasWMOInfo;

    /**
     * Station type.
     *
     * @var StationType
     */
    public StationType $type;

    /**
     * Owner of station.
     *
     * @var string
     */
    public string $owner;

    /**
     * Height of anemometer (in meters).
     *
     * @var float|null
     */
    public ?float $anemometerHeight;

    /**
     * Height of barometer (in meters).
     *
     * @var float|null
     */
    public ?float $barometerHeight;

    /**
     * Height of station (in meters).
     *
     * @var float|null
     */
    public ?float $stationHeight;

    /**
     * Measurements delivered by station.
     *
     * @var Collection
     */
    public Collection $measurements;

    /**
     * Meteorological constructor.
     *
     * @param array|Collection $data
     */
    public function __construct(array|Collection $data)
    {
        // Make sure data is a Collection.
        // but without a few fields, who needs merging.
        $collection = Collection::wrap(value: $data)->except(keys: [
            'operationFrom', 'operationTo',
            'validFrom', 'validTo',
        ]);

        // Merge removed fields and add them to the Collection.
        $collection->put(key: 'operationalPeriod', value: ['from' => $data['operationFrom'] ?? null, 'to' => $data['operationTo'] ?? null])
            ->put(key: 'validityPeriod', value: ['from' => $data['validFrom'] ?? null, 'to' => $data['validTo'] ?? null]);

        // Send re-arranged Collection to parent.
        parent::__construct(data: $collection);
    }

    /**
     * Set station type.
     *
     * @param string $type
     * @return $this
     */
    protected function setType(string $type): self
    {
        $this->type = StationType::from(value: $type);
        return $this;
    }

    /**
     * Set delivered measurements by station.
     *
     * @param Collection $parameters
     * @return $this
     */
    public function setParameterId(Collection $parameters): self
    {
        $this->measurements = $parameters->map(callback: fn (string $parameter) => Parameter::tryFrom(value: $parameter))->filter();
        return $this;
    }
}
