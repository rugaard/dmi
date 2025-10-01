<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums;

/**
 * Enum Services.
 *
 * @return string
 */
enum Service: string
{
    case Climate = 'climateData';
    case Lightning = 'lightningdata';
    case Meteorological = 'metObs';
    case Oceanographic = 'oceanObs';
    case Radar = 'radardata';
}
