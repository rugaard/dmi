<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Radar;

/**
 * Enum ScanType.
 *
 * @return string
 */
enum ScanType: string
{
    case FullRange = 'fullRange';
    case Doppler = 'doppler';
}
