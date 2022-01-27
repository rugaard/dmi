<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO;

use DateTime;
use Rugaard\DMI\Old\DTO\SunTime;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class SunTimeTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO
 */
class SunTimeTest extends AbstractTestCase
{
    /**
     * Test set/get sunrise.
     *
     * @return void
     */
    public function testSunrise() : void
    {
        // Instantiate empty DTO.
        $dto = new SunTime;

        // Mocked timestamp.
        $mockedTimestamp = '2019-06-30 04:25';

        // Set sunrise.
        $dto->setSunrise($mockedTimestamp);

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getSunrise());
        $this->assertEquals($mockedTimestamp, $dto->getSunrise()->format('Y-m-d H:i'));
        $this->assertEquals('Europe/Copenhagen', $dto->getSunrise()->getTimezone()->getName());
    }

    /**
     * Test set/get sunset.
     *
     * @return void
     */
    public function testSunset() : void
    {
        // Instantiate empty DTO.
        $dto = new SunTime;

        // Mocked timestamp.
        $mockedTimestamp = '2019-06-30 21:59';

        // Set sunrise.
        $dto->setSunset($mockedTimestamp);

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getSunset());
        $this->assertEquals($mockedTimestamp, $dto->getSunset()->format('Y-m-d H:i'));
        $this->assertEquals('Europe/Copenhagen', $dto->getSunset()->getTimezone()->getName());
    }
}
