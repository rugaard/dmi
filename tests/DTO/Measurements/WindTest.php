<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements;

use Rugaard\DMI\DTO\Measurements\Wind;
use Rugaard\DMI\DTO\Measurements\Wind\WindDirection;
use Rugaard\DMI\DTO\Measurements\Wind\Gust;
use Rugaard\DMI\DTO\Measurements\Wind\Speed;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class WindTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurement
 */
class WindTest extends AbstractTestCase
{
    /**
     * Mocked test data.
     *
     * @var array|null
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
        $this->mockedData = json_decode(file_get_contents(__DIR__ . '/../../Support/MockedResponses/JSON/Location.json'), true)['timeserie'][0];

        parent::setUp();
    }

    /**
     * Test set/get speed.
     *
     * @return void
     */
    public function testSpeed() : void
    {
        // Instantiate empty DTO.
        $dto = new Wind;

        // Set wind speed.
        $dto->setSpeed(new Speed($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Speed::class, $dto->getSpeed());
    }

    /**
     * Test set/get direction.
     *
     * @return void
     */
    public function testDirection() : void
    {
        // Instantiate empty DTO.
        $dto = new Wind;

        // Set wind direction.
        $dto->setDirection(new WindDirection($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(WindDirection::class, $dto->getDirection());
    }

    /**
     * Test set/get gust.
     *
     * @return void
     */
    public function testGust() : void
    {
        // Instantiate empty DTO.
        $dto = new Wind;

        // Set wind gust.
        $dto->setGust(new Gust($this->mockedData));

        // Assertions.
        $this->assertInstanceOf(Gust::class, $dto->getGust());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Wind;

        // Set wind speed.
        $dto->setSpeed(new Speed($this->mockedData));

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('2.9 m/s', (string) $dto);
    }
}
