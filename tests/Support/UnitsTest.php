<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Support;

use Rugaard\DMI\DTO\Units\Bearing;
use Rugaard\DMI\DTO\Units\Length\Centimeter;
use Rugaard\DMI\DTO\Units\Length\Meter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\DTO\Units\Time\Hour;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class UnitsTest.
 *
 * @package Rugaard\DMI\Tests\Support
 */
class UnitsTest extends AbstractTestCase
{
    /**
     * Test full danish month name by month no.
     *
     * @return void
     */
    public function testGetUnitByAbbreviation() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            // Temperatures.
            ['abbreviation' => '°C', 'expectedUnit' => Celsius::class],
            // Speed.
            ['abbreviation' => 'm/s', 'expectedUnit' => MetersPerSecond::class],
            // Length.
            ['abbreviation' => 'cm', 'expectedUnit' => Centimeter::class],
            ['abbreviation' => 'm', 'expectedUnit' => Meter::class],
            ['abbreviation' => 'mm', 'expectedUnit' => Millimeter::class],
            // Pressure.
            ['abbreviation' => 'hPa', 'expectedUnit' => Hectopascal::class],
            // Time.
            ['abbreviation' => 'timer', 'expectedUnit' => Hour::class],
            // Miscellaneous.
            ['abbreviation' => 'grader', 'expectedUnit' => Bearing::class],
            ['abbreviation' => '%', 'expectedUnit' => Percentage::class],
        ]);

        $mockedData->each(function ($data) {
            // Get unit by abbreviation.
            $unit = getUnitByAbbreviation($data['abbreviation']);

            // Assertions.
            $this->assertInstanceOf($data['expectedUnit'], $unit);
        });

        // Assert non-supported unit abbreviation.
        $this->assertNull(getUnitByAbbreviation('N/A'));
    }
}