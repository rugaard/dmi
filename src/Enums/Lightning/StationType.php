<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Lightning;

/**
 * Enum StationType.
 *
 * @return string
 */
enum StationType: string
{
    case LightningSensor = 'Lightning';

    /**
     * Get description of lightning station types.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::LightningSensor => 'Registers and triangulates lightning strokes.',
        };
    }
}
