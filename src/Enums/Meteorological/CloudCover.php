<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Meteorological;

/**
 * Enum CloudCover.
 *
 * @return int
 */
enum CloudCover: int
{
    case Clear = 0;
    case FewCloudsOrClear = 1;
    case FewClouds = 2;
    case ScatteredClouds = 3;
    case PartlyCloudy = 4;
    case BrokenClouds = 5;
    case Cloudy = 6;
    case VeryCloudy = 7;
    case Overcast = 8;
    case Obscured = 9;

    /**
     * Get cloud cover description.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Clear => 'Sky clear',
            self::FewCloudsOrClear => '1/8 of the sky covered or less, but not zero',
            self::FewClouds => '2/8 of the sky covered',
            self::ScatteredClouds => '3/8 of the sky covered',
            self::PartlyCloudy => '4/8 of the sky covered',
            self::BrokenClouds => '5/8 of the sky covered',
            self::Cloudy => '6/8 of the sky covered',
            self::VeryCloudy => '7/8 of the sky covered, but not 8/8',
            self::Overcast => '8/8 of the sky completely covered, no breaks',
            self::Obscured => 'Sky obscured by fog and/or other meteorological phenomena',
        };
    }

    /**
     * Get cloud cover abbreviation.
     *
     * @return string
     */
    public function abbreviation(): string
    {
        return match ($this) {
            self::Clear => 'SKC',
            self::FewCloudsOrClear, self::FewClouds => 'FEW',
            self::ScatteredClouds, self::PartlyCloudy => 'SCT',
            self::BrokenClouds, self::Cloudy, self::VeryCloudy => 'BKN',
            self::Overcast => 'OVC',
            self::Obscured => '-',
        };
    }

    /**
     * Get cloud cover as a percentage range.
     *
     * @return string
     */
    public function percentage(): string
    {
        return match ($this) {
            self::Clear => '0-12.4%',
            self::FewCloudsOrClear => '12.5-24%',
            self::FewClouds => '25-37.4%',
            self::ScatteredClouds => '37.5-49%',
            self::PartlyCloudy => '50-62.4%',
            self::BrokenClouds => '62.5-74%',
            self::Cloudy => '75-87.4%',
            self::VeryCloudy => '87.5-99%',
            self::Overcast, self::Obscured => '100%',
        };
    }
}
