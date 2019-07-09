<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Measurements\Wind;

use Rugaard\DMI\DTO\Measurements\Wind\Direction;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class DirectionTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Measurements\Wind
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
            Collection::make(['value' => 338, 'expectedDirection' => 'Nord']),
            Collection::make(['value' => 293, 'expectedDirection' => 'Nordvest']),
            Collection::make(['value' => 248, 'expectedDirection' => 'Vest']),
            Collection::make(['value' => 203, 'expectedDirection' => 'Sydvest']),
            Collection::make(['value' => 158, 'expectedDirection' => 'Syd']),
            Collection::make(['value' => 113, 'expectedDirection' => 'Sydøst']),
            Collection::make(['value' => 68, 'expectedDirection' => 'Øst']),
            Collection::make(['value' => 23, 'expectedDirection' => 'Nordøst']),
            Collection::make(['value' => 0, 'expectedDirection' => 'Nord']),
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
        $this->assertIsFloat($dto->getDegrees());
        $this->assertEquals(0.0, $dto->getDegrees());
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
            Collection::make(['value' => 338, 'expectedDirection' => 'Nord']),
            Collection::make(['value' => 293, 'expectedDirection' => 'Nordvest']),
            Collection::make(['value' => 248, 'expectedDirection' => 'Vest']),
            Collection::make(['value' => 203, 'expectedDirection' => 'Sydvest']),
            Collection::make(['value' => 158, 'expectedDirection' => 'Syd']),
            Collection::make(['value' => 113, 'expectedDirection' => 'Sydøst']),
            Collection::make(['value' => 68, 'expectedDirection' => 'Øst']),
            Collection::make(['value' => 23, 'expectedDirection' => 'Nordøst']),
            Collection::make(['value' => 0, 'expectedDirection' => 'Nord']),
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
            Collection::make(['value' => 'N', 'expectedDirection' => 'Nord']),
            Collection::make(['value' => 'S', 'expectedDirection' => 'Syd']),
            Collection::make(['value' => 'Ø', 'expectedDirection' => 'Øst']),
            Collection::make(['value' => 'V', 'expectedDirection' => 'Vest']),
            Collection::make(['value' => 'NØ', 'expectedDirection' => 'Nordøst']),
            Collection::make(['value' => 'NV', 'expectedDirection' => 'Nordvest']),
            Collection::make(['value' => 'SØ', 'expectedDirection' => 'Sydøst']),
            Collection::make(['value' => 'SV', 'expectedDirection' => 'Sydvest']),
            Collection::make(['value' => 'NNØ', 'expectedDirection' => 'Nord-nordøst']),
            Collection::make(['value' => 'NNV', 'expectedDirection' => 'Nord-nordvest']),
            Collection::make(['value' => 'ØNØ', 'expectedDirection' => 'Øst-nordøst']),
            Collection::make(['value' => 'ØSØ', 'expectedDirection' => 'Øst-sydøst']),
            Collection::make(['value' => 'SSØ', 'expectedDirection' => 'Syd-sydøst']),
            Collection::make(['value' => 'SSV', 'expectedDirection' => 'Syd-sydvest']),
            Collection::make(['value' => 'VNV', 'expectedDirection' => 'Vest-nordvest']),
            Collection::make(['value' => 'VSV', 'expectedDirection' => 'Vest-sydvest']),
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
        $mockedDirection = 'NØ';

        // Set direction.
        $dto->setDirection($mockedDirection);

        // Assertions.
        $this->assertIsString((string) $dto);
        $this->assertEquals('Nordøst', (string) $dto);
    }
}