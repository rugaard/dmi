<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Support\Traits;

use Rugaard\DMI\Old\Support\Traits\Icon;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class IconTest.
 *
 * @package Rugaard\DMI\Old\Tests\Support\Traits
 */
class IconTest extends AbstractTestCase
{
    /**
     * Mocked test data.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $mockedData;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Mocked test data.
        $this->mockedData = Collection::make([
            1 => 'clear',
            2 => 'partly-cloudy',
            3 => 'cloudy',
            38 => 'blowing-snow',
            45 => 'foggy',
            60 => 'light-rain',
            63 => 'heavy-rain',
            68 => 'light-sleet',
            69 => 'heavy-sleet',
            70 => 'light-snow',
            73 => 'heavy-snow',
            80 => 'clear-light-rain',
            81 => 'clear-heavy-rain',
            83 => 'clear-light-sleet',
            84 => 'clear-heavy-sleet',
            85 => 'clear-light-snow',
            86 => 'clear-heavy-snow',
            95 => 'thunderstorm',
            101 => 'clear-night',
            102 => 'partly-cloudy-night',
            103 => 'cloudy-night',
            138 => 'blowing-snow-night',
            145 => 'foggy-night',
            160 => 'light-rain-night',
            163 => 'heavy-rain-night',
            168 => 'light-sleet-night',
            169 => 'heavy-sleet-night',
            170 => 'light-snow-night',
            173 => 'heavy-snow-night',
            180 => 'clear-light-rain-night',
            181 => 'clear-heavy-rain-night',
            183 => 'clear-light-sleet-night',
            184 => 'clear-heavy-sleet-night',
            185 => 'clear-light-snow-night',
            186 => 'clear-heavy-snow-night',
            195 => 'thunderstorm-night',
        ]);

        parent::setUp();
    }

    /**
     * Test set/get icon by ID.
     *
     * @return void
     */
    public function testIconById(): void
    {
        $this->mockedData->each(function ($icon, $id) {
            // Instantiate trait.
            $trait = new class { use Icon; };

            // Set icon by ID.
            $trait->setIconById($id);

            // Assertions.
            $this->assertIsString($trait->getIcon());
            $this->assertEquals($icon, $trait->getIcon());
        });
    }

    /**
     * Test set/get icon by ID.
     *
     * @return void
     */
    public function testIcon(): void
    {
        $this->mockedData->each(function ($icon) {
            // Instantiate trait.
            $trait = new class { use Icon; };

            // Set icon.
            $trait->setIcon($icon);

            // Assertions.
            $this->assertIsString($trait->getIcon());
            $this->assertEquals($icon, $trait->getIcon());
        });
    }
}
