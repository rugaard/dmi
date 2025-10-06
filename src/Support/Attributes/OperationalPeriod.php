<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use Illuminate\Support\Collection;
use Rugaard\DMI\DTO\DateTimePeriod;

/**
 * Trait OperationalPeriod.
 */
trait OperationalPeriod
{
    /**
     * Operational time-period.
     *
     * @var DateTimePeriod
     */
    public DateTimePeriod $operationalPeriod;

    /**
     * Set operational time-period.
     *
     * @param Collection $period
     * @return $this
     */
    protected function setOperationalPeriod(Collection $period): self
    {
        $this->operationalPeriod = new DateTimePeriod(fromDate: $period->get(key: 'from'), toDate: $period->get(key: 'to'));
        return $this;
    }
}
