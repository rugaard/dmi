<?php
declare(strict_types=1);

use Rugaard\DMI\Old\Contracts\Unit;
use Rugaard\DMI\Old\Units\Bearing;
use Rugaard\DMI\Old\Units\Percentage;
use Rugaard\DMI\Old\Units\Length\Centimeter;
use Rugaard\DMI\Old\Units\Length\Meter;
use Rugaard\DMI\Old\Units\Length\Millimeter;
use Rugaard\DMI\Old\Units\Pressure\Hectopascal;
use Rugaard\DMI\Old\Units\Speed\MetersPerSecond;
use Rugaard\DMI\Old\Units\Temperature\Celsius;
use Rugaard\DMI\Old\Units\Time\Hour;

if (!function_exists('getUnitByAbbreviation')) {
    /**
     * Get unit by abbreviation.
     *
     * @param  string $unitAbbreviation
     * @return \Rugaard\DMI\Old\Contracts\Unit|null
     */
    function getUnitByAbbreviation(string $unitAbbreviation) :? Unit
    {
        switch ($unitAbbreviation) {
            // Temperatures.
            case '°C':
                return new Celsius;
                break;
            // Speed
            case 'm/s':
                return new MetersPerSecond;
                break;
            // Length
            case 'cm':
                return new Centimeter;
                break;
            case 'm':
                return new Meter;
                break;
            case 'mm':
                return new Millimeter;
                break;
            // Pressure
            case 'hPa':
                return new Hectopascal;
                break;
            // Time
            case 'timer':
                return new Hour;
                break;
            // Miscellaneous
            case 'grader':
                return new Bearing;
                break;
            case '%':
                return new Percentage;
                break;
            default:
                return null;
        }
    }
}
