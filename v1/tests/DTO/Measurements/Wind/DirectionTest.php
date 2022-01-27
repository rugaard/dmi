<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO\Measurements\Wind;

use Rugaard\DMI\Old\DTO\Measurements\Wind\Direction;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class DirectionTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO\Measurements\Wind
 */
class DirectionTest extends AbstractTestCase
{
    /**
     * Test set/get degrees and direction.
     *
     * @return void
     */
    public function testDegreesAndDirection() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            Collection::make(['value' => 338, 'expectedDirection' => 'North']),
            Collection::make(['value' => 293, 'expectedDirection' => 'Northwest']),
            Collection::make(['value' => 248, 'expectedDirection' => 'West']),
            Collection::make(['value' => 203, 'expectedDirection' => 'Southwest']),
            Collection::make(['value' => 158, 'expectedDirection' => 'South']),
            Collection::make(['value' => 113, 'expectedDirection' => 'Southeast']),
            Collection::make(['value' => 68, 'expectedDirection' => 'East']),
            Collection::make(['value' => 23, 'expectedDirection' => 'Northeast']),
            Collection::make(['value' => 0, 'expectedDirection' => 'North']),
        ]);

        // Test each wind degree.
        $mockedData->each(function ($data) {
            // Instantiate empty DTO.
            $dto = new Direction;

            // Set direction.
            $dto->setDegreesAndDirection($data->get('value'));

            // Assertions.
            $this->assertIsFloat($dto->getDegrees());
            $this->assertEquals($data->get('value'), $dto->getDegrees());
            $this->assertIsString($dto->getDirection());
            $this->assertEquals($data->get('expectedDirection'), $dto->getDirection());
        });

        // Test non-existing wind direction.
        $dto = (new Direction)->setDirectionByDegrees(-1);
        $this->assertNull($dto->getDegrees());
        $this->assertNull($dto->getDirection());
    }

    /**
     * Test set/get direction by degrees.
     *
     * @return void
     */
    public function testDirectionByDegrees() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            Collection::make(['value' => 338, 'expectedDirection' => 'North']),
            Collection::make(['value' => 293, 'expectedDirection' => 'Northwest']),
            Collection::make(['value' => 248, 'expectedDirection' => 'West']),
            Collection::make(['value' => 203, 'expectedDirection' => 'Southwest']),
            Collection::make(['value' => 158, 'expectedDirection' => 'South']),
            Collection::make(['value' => 113, 'expectedDirection' => 'Southeast']),
            Collection::make(['value' => 68, 'expectedDirection' => 'East']),
            Collection::make(['value' => 23, 'expectedDirection' => 'Northeast']),
            Collection::make(['value' => 0, 'expectedDirection' => 'North']),
        ]);

        // Test each wind degree.
        $mockedData->each(function ($data) {
            // Instantiate empty DTO.
            $dto = new Direction;

            // Set direction.
            $dto->setDirectionByDegrees($data->get('value'));

            // Assertions.
            $this->assertIsString($dto->getDirection());
            $this->assertEquals($data->get('expectedDirection'), $dto->getDirection());

        });

        // Test non-existing wind direction.
        $dto = (new Direction)->setDirectionByDegrees(-1);
        $this->assertNull($dto->getDirection());
    }

    /**
     * Test set/get direction.
     *
     * @return void
     */
    public function testDirection() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            Collection::make(['value' => 'N', 'expectedDirection' => 'North']),
            Collection::make(['value' => 'S', 'expectedDirection' => 'South']),
            Collection::make(['value' => 'E', 'expectedDirection' => 'East']),
            Collection::make(['value' => 'W', 'expectedDirection' => 'West']),
            Collection::make(['value' => 'NE', 'expectedDirection' => 'Northeast']),
            Collection::make(['value' => 'NW', 'expectedDirection' => 'Northwest']),
            Collection::make(['value' => 'SE', 'expectedDirection' => 'Southeast']),
            Collection::make(['value' => 'SW', 'expectedDirection' => 'Southwest']),
            Collection::make(['value' => 'NNE', 'expectedDirection' => 'North-northeast']),
            Collection::make(['value' => 'NNW', 'expectedDirection' => 'North-northwest']),
            Collection::make(['value' => 'ENE', 'expectedDirection' => 'East-northeast']),
            Collection::make(['value' => 'ESE', 'expectedDirection' => 'East-southeast']),
            Collection::make(['value' => 'SSE', 'expectedDirection' => 'South-southeast']),
            Collection::make(['value' => 'SSW', 'expectedDirection' => 'South-southwest']),
            Collection::make(['value' => 'WNW', 'expectedDirection' => 'West-northwest']),
            Collection::make(['value' => 'WSW', 'expectedDirection' => 'West-southwest']),
        ]);

        // Test each wind direction.
        $mockedData->each(function ($data) {
            // Instantiate empty DTO.
            $dto = new Direction;

            // Set direction.
            $dto->setDirection($data->get('value'));

            // Assertions.
            $this->assertIsString($dto->getDirection());
            $this->assertEquals($data->get('expectedDirection'), $dto->getDirection());

        });

        // Test non-existing wind direction.
        $dto = (new Direction)->setDirection('N/A');
        $this->assertNull($dto->getDirection());
    }

    /**
     * Test set/get abbreviation.
     *
     * @return void
     */
    public function testAbbreviation() : void
    {
        // Instantiate empty DTO.
        $dto = new Direction;

        // Mocked abbreviation
        $mockedAbbreviation = 'S';

        // Set abbreviation.
        $dto->setAbbreviation($mockedAbbreviation);

        // Assertions.
        $this->assertIsString($dto->getAbbreviation());
        $this->assertEquals($mockedAbbreviation, $dto->getAbbreviation());
    }

    /**
     * Test set/get degrees.
     *
     * @return void
     */
    public function testDegrees() : void
    {
        // Instantiate empty DTO.
        $dto = new Direction;

        // Mocked degrees.
        $mockedDegrees = 131.761903;

        // Set degrees.
        $dto->setDegrees($mockedDegrees);

        // Assertions.
        $this->assertIsFloat($dto->getDegrees());
        $this->assertEquals($mockedDegrees, $dto->getDegrees());
    }

    /**
     * Test __toString()
     *
     * @return void
     */
    public function testToString() : void
    {
        // Instantiate empty DTO.
        $dto = new Direction;

        // Mocked direction.
        $mockedDirection = 'NE';

        // Set direction.
        $dto->setDirection($mockedDirection);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('Northeast', (string) $dto);
    }
}
