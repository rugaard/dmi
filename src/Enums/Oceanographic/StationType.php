<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Oceanographic;

/**
 * Enum StationType.
 *
 * @return string
 */
enum StationType: string
{
    case TideGaugePrimary = 'Tide-gauge-primary';
    case TideGaugeSecondary = 'Tide-gauge-secondary';

    /**
     * Get description of station type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::TideGaugePrimary => 'Primary tide-gauge is recording the sea level changes',
            self::TideGaugeSecondary => 'Secondary tide-gauge is recording the sea level changes',
        };
    }
}
