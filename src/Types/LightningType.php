<?php

declare(strict_types=1);

namespace Rugaard\DMI\Types;

use Rugaard\DMI\DTO\Lightning\Lightning;

/**
 * Enum LightningType.
 *
 * @package Rugaard\DMI\Types
 * @return string
 */
enum LightningType: string
{
    /**
     * Cloud-to-ground with a negative charge.
     */
    case CloudToGroundNegative = '0';

    /**
     * Cloud-to-ground with a positive charge.
     */
    case CloudToGroundPositive = '1';

    /**
     * Cloud-to-cloud.
     */
    case CloudToCloud = '2';

    /**
     * Get description of lightning type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::CloudToGroundNegative => 'Cloud-to-ground lightning stroke with a negative charge',
            self::CloudToGroundPositive => 'Cloud-to-ground lightning stroke with a positive charge',
            self::CloudToCloud => 'Cloud-to-cloud lightning stroke',
        };
    }

    /**
     * Get class namespace of matching lightning type.
     *
     * @return string
     */
    public function type(): string
    {
        return Lightning::class;
    }
}
