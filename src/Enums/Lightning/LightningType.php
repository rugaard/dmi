<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Lightning;

/**
 * Enum Lightning.
 *
 * @return string
 */
enum LightningType: int
{
    case CloudToGroundNegative = 0;
    case CloudToGroundPositive = 1;
    case CloudToCloud = 2;

    /**
     * Get description of lightning type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::CloudToGroundNegative => 'Cloud-to-ground with a negative charge',
            self::CloudToGroundPositive => 'Cloud-to-ground with a positive charge',
            self::CloudToCloud => 'Cloud-to-cloud',
        };
    }
}
