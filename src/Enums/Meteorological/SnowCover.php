<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Meteorological;

/**
 * Enum SnowCover.
 *
 * @return int
 */
enum SnowCover: int
{
    case None = 0;
    case OneQuarter = 1;
    case TwoQuarters = 2;
    case ThreeQuarters = 3;
    case FourQuarters = 4;

    /**
     * Get snow cover description.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::None => 'No snow',
            self::OneQuarter => '1/4 of the ground is covered in snow',
            self::TwoQuarters => '2/4 of the ground is covered in snow',
            self::ThreeQuarters => '3/4 of the ground is covered in snow',
            self::FourQuarters => 'Ground is fully covered in snow',
        };
    }

    /**
     * Get snow cover as a percentage range.
     *
     * @return string
     */
    public function percentage(): string
    {
        return match ($this) {
            self::None => '0%',
            self::OneQuarter => '25%',
            self::TwoQuarters => '50%',
            self::ThreeQuarters => '75%',
            self::FourQuarters => '100%',
        };
    }
}
