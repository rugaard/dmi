<?php
declare(strict_types=1);

use Rugaard\OldDMI\Contracts\Unit;
use Rugaard\OldDMI\Units\Bearing;
use Rugaard\OldDMI\Units\Percentage;
use Rugaard\OldDMI\Units\Length\Centimeter;
use Rugaard\OldDMI\Units\Length\Meter;
use Rugaard\OldDMI\Units\Length\Millimeter;
use Rugaard\OldDMI\Units\Pressure\Hectopascal;
use Rugaard\OldDMI\Units\Speed\MetersPerSecond;
use Rugaard\OldDMI\Units\Temperature\Celsius;
use Rugaard\OldDMI\Units\Time\Hour;

if (!function_exists('getUnitByAbbreviation')) {
    /**
     * Get unit by abbreviation.
     *
     * @param  string $unitAbbreviation
     * @return \Rugaard\OldDMI\Contracts\Unit|null
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
