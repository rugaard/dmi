<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums;

/**
 * Enum QualityControlStatus.
 *
 * @return string
 */
enum QualityControlStatus: string
{
    case None = 'none';
    case Auto = 'auto';
    case Manual = 'manual';

    /**
     * Get description of quality control status.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::None => 'No quality control has been performed',
            self::Auto => 'Automatic real-time quality control has been performed',
            self::Manual => 'Manual quality control has been performed',
        };
    }
}
