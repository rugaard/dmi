<?php
declare(strict_types=1);

use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\Units\Bearing;
use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\DTO\Units\Length\Centimeter;
use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\DTO\Units\Time\Hour;

if (!function_exists('getUnitByAbbreviation')) {
    /**
     * Get unit by abbreviation.
     *
     * @param  string $unitAbbreviation
     * @return \Rugaard\DMI\Contracts\Unit|null
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