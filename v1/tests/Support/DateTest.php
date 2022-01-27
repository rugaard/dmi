<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Support;

use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class DateTest.
 *
 * @package Rugaard\DMI\Old\Tests\Support
 */
class DateTest extends AbstractTestCase
{
    /**
     * Danish months.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $danishMonths;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        $this->danishMonths = Collection::make([
            1 => ['month' => 'januar', 'short' => 'jan'],
            2 => ['month' => 'februar', 'short' => 'feb'],
            3 => ['month' => 'marts', 'short' => 'mar'],
            4 => ['month' => 'april', 'short' => 'apr'],
            5 => ['month' => 'maj', 'short' => 'maj'],
            6 => ['month' => 'juni', 'short' => 'jun'],
            7 => ['month' => 'juli', 'short' => 'jul'],
            8 => ['month' => 'august', 'short' => 'aug'],
            9 => ['month' => 'september', 'short' => 'sep'],
            10 => ['month' => 'oktober', 'short' => 'okt'],
            11 => ['month' => 'november', 'short' => 'nov'],
            12 => ['month' => 'december', 'short' => 'dec'],
        ]);

        parent::setUp();
    }

    /**
     * Test full danish month name by month no.
     *
     * @return void
     */
    public function testFullDanishMonthNameByMonthNo() : void
    {
        $this->danishMonths->each(function ($data, $monthNo) {
            // Get month name.
            $result = getDanishMonthNameByMonthNo($monthNo);

            // Assertions.
            $this->assertIsString($result);
            $this->assertEquals($data['month'], $result);
        });

        // Test invalid month no.
        $this->assertNull(getDanishMonthNameByMonthNo(0));
    }

    /**
     * Test short danish month name by month no.
     *
     * @return void
     */
    public function testShortDanishMonthNameByMonthNo() : void
    {
        $this->danishMonths->each(function ($data, $monthNo) {
            // Get month name.
            $result = getDanishMonthNameByMonthNo($monthNo, true);

            // Assertions.
            $this->assertIsString($result);
            $this->assertEquals($data['short'], $result);
        });

        // Test invalid month no.
        $this->assertNull(getDanishMonthNameByMonthNo(0, true));
    }
}
