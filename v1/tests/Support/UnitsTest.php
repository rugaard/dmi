<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Support;

use Rugaard\DMI\Old\DTO\Units\Bearing;
use Rugaard\DMI\Old\DTO\Units\Length\Centimeter;
use Rugaard\DMI\Old\DTO\Units\Length\Meter;
use Rugaard\DMI\Old\DTO\Units\Length\Millimeter;
use Rugaard\DMI\Old\DTO\Units\Percentage;
use Rugaard\DMI\Old\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\Old\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\Old\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\Old\DTO\Units\Time\Hour;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class UnitsTest.
 *
 * @package Rugaard\DMI\Old\Tests\Support
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
