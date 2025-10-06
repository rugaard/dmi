<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Meteorological;

/**
 * Enum StationType.
 *
 * @return string
 */
enum StationType: string
{
    case Synop = 'Synop';
    case GIWS = 'GIWS';
    case Pluvio = 'Pluvio';
    case ManualPrecipitation = 'Manual precipitation';
    case ManualSnow = 'Manual snow';

    /**
     * Get description of station type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Synop => 'Weather stations that register a wide variety of meteorological parameters, e.g. temperature, wind, pressure, and precipitation.',
            self::GIWS => 'Weather stations that register a wide variety of meteorological parameters, e.g. temperature, wind, and pressure.',
            self::Pluvio => 'Precipitation stations register data concerning precipitation. Precipitation is also measured by some synop-stations.',
            self::ManualPrecipitation => 'In Greenland the precipitation is at some locations measured manually once a day. Once a month DMI receives the data, whereafter the data will be available through our API-services.',
            self::ManualSnow => 'In Denmark the snow depth and cover is measured manually once a day.',
        };
    }
}
