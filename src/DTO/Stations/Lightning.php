<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Stations;

use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Station;
use Rugaard\DMI\Enums\Lightning\StationType;
use Rugaard\DMI\Support\Attributes\ActiveStatus as HasActiveStatus;
use Rugaard\DMI\Support\Attributes\OperationalPeriod as HasOperationalPeriod;
use Rugaard\DMI\Support\Attributes\UpdatedTimestamp as HasUpdatedTimestamp;
use Rugaard\DMI\Support\Attributes\ValidityPeriod as HasValidityPeriod;

/**
 * Class Lightning.
 */
class Lightning extends Station
{
    use HasActiveStatus, HasOperationalPeriod, HasUpdatedTimestamp, HasValidityPeriod;

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
     * Sensor ID of station.
     *
     * @var int
     */
    public int $sensorId;

    /**
     * Timestamp of last heartbeat from station.
     *
     * @var DateTime|null
     */
    public ?DateTime $lastHeartbeatAt = null;

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
     * Set sensor ID of station.
     *
     * @param string $value
     * @return $this
     */
    protected function setSensorId(string $value): self
    {
        $this->sensorId = (int) $value;
        return $this;
    }

    /**
     * Set timestamp of last heartbeat.
     *
     * @param string|null $datetime
     * @return $this
     */
    protected function setLastHeartbeat(?string $datetime): self
    {
        try {
            $this->lastHeartbeatAt = $datetime !== null ? (new DateTime($datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC')) : null;
        } catch (Exception) {
            //
        }
        return $this;
    }
}
