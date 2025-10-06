<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Oceanographic;

/**
 * Enum QualityControlStatus.
 *
 * @return int
 */
enum QualityControl: int
{
    case OK = 0;
    case WaterLevelTooHigh = 1;
    case WaterLevelTooLow = 2;
    case ChangeTooBig = 3;
    case ValueLocked = 4;
    case WaterTemperatureError = 5;
    case Erroneous = 6;

    /**
     * Get description of quality control value.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::OK => 'No errors found',
            self::WaterLevelTooHigh => 'Value check - water level too high',
            self::WaterLevelTooLow => 'Value check – water level too low',
            self::ChangeTooBig => 'Step check - change too big',
            self::ValueLocked => 'Step check - value locked',
            self::WaterTemperatureError => 'Consistency check – water temperature error',
            self::Erroneous => 'Data is erroneous',
        };
    }
}
