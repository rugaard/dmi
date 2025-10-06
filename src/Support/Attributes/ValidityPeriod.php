<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use Illuminate\Support\Collection;
use Rugaard\DMI\DTO\DateTimePeriod;

/**
 * Trait ValidityPeriod.
 */
trait ValidityPeriod
{
    /**
     * Validity time-period.
     *
     * @var DateTimePeriod
     */
    public DateTimePeriod $validityPeriod;

    /**
     * Set validity time-period.
     *
     * @param Collection $period
     * @return $this
     */
    protected function setValidityPeriod(Collection $period): self
    {
        $this->validityPeriod = new DateTimePeriod(fromDate: $period->get(key: 'from'), toDate: $period->get(key: 'to'));
        return $this;
    }
}
