<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO;

use Rugaard\DMI\DTO\Pollen;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class PollenTest.
 *
 * @package Rugaard\DMI\Tests\DTO
 */
class PollenTest extends AbstractTestCase
{
    /**
     * Test set/get name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate empty DTO.
        $dto = new Pollen;

        // Mocked name.
        $mockedName = 'Mocked name';

        // Set name.
        $dto->setName($mockedName);

        // Assertion.
        $this->assertIsString($dto->getName());
        $this->assertEquals($mockedName, $dto->getName());
    }

    /**
     * Test set/get forecast.
     *
     * @return void
     */
    public function testForecast() : void
    {
        // Instantiate empty DTO.
        $dto = new Pollen;

        // Mocked forecast.
        $mockedForecast = 'This is a mocked forecast.';

        // Set forecast.
        $dto->setForecast($mockedForecast);

        // Assertion.
        $this->assertIsString($dto->getForecast());
        $this->assertEquals($mockedForecast, $dto->getForecast());
    }

    /**
     * Test set/get readings.
     *
     * @return void
     */
    public function testReadings() : void
    {
        // Instantiate empty DTO.
        $dto = new Pollen;

        // Set readings.
        $dto->setReadings(Collection::make());

        // Assertion.
        $this->assertInstanceOf(Collection::class, $dto->getReadings());
    }

    /**
     * Test pollen levels.
     *
     * @return void
     */
    public function testPollenLevels() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            'Birk' => Collection::make([
                ['value' => 101, 'expectedLevel' => 'High'],
                ['value' => 31, 'expectedLevel' => 'Moderate'],
                ['value' => 1, 'expectedLevel' => 'Low'],
                ['value' => 0, 'expectedLevel' => null]
            ]),
            'Bynke' => Collection::make([
                ['value' => 51, 'expectedLevel' => 'High'],
                ['value' => 11, 'expectedLevel' => 'Moderate'],
                ['value' => 1, 'expectedLevel' => 'Low'],
                ['value' => 0, 'expectedLevel' => null]
            ]),
            'El' => Collection::make([
                ['value' => 51, 'expectedLevel' => 'High'],
                ['value' => 11, 'expectedLevel' => 'Moderate'],
                ['value' => 1, 'expectedLevel' => 'Low'],
                ['value' => 0, 'expectedLevel' => null]
            ]),
            'Elm' => Collection::make([
                ['value' => 51, 'expectedLevel' => 'High'],
                ['value' => 11, 'expectedLevel' => 'Moderate'],
                ['value' => 1, 'expectedLevel' => 'Low'],
                ['value' => 0, 'expectedLevel' => null]
            ]),
            'Græs' => Collection::make([
                ['value' => 51, 'expectedLevel' => 'High'],
                ['value' => 11, 'expectedLevel' => 'Moderate'],
                ['value' => 1, 'expectedLevel' => 'Low'],
                ['value' => 0, 'expectedLevel' => null]
            ]),
            'Hassel' => Collection::make([
                ['value' => 16, 'expectedLevel' => 'High'],
                ['value' => 6, 'expectedLevel' => 'Moderate'],
                ['value' => 1, 'expectedLevel' => 'Low'],
                ['value' => 0, 'expectedLevel' => null]
            ]),
            'Alternaria' => Collection::make([
                ['value' => 'Højt', 'expectedLevel' => 'High'],
                ['value' => 'Moderat', 'expectedLevel' => 'Moderate'],
                ['value' => 'Lavt', 'expectedLevel' => 'Low'],
                ['value' => '-', 'expectedLevel' => null]
            ]),
            'Cladosporium' => Collection::make([
                ['value' => 'Højt', 'expectedLevel' => 'High'],
                ['value' => 'Moderat', 'expectedLevel' => 'Moderate'],
                ['value' => 'Lavt', 'expectedLevel' => 'Low'],
                ['value' => '-', 'expectedLevel' => null],
            ]),
        ]);

        // Instantiate empty DTO.
        $dto = new Pollen;

        // Test each pollen type
        // for each available level.
        $mockedData->each(function ($data, $pollenName) use ($dto) {
            $data->each(function ($test) use ($dto, $pollenName) {
                $result = in_array($pollenName, ['Alternaria', 'Cladosporium'])
                    ? $this->invokeMethod($dto, 'determinePollenLevelByText', [$test['value']])
                    : $this->invokeMethod($dto, 'getPollenLevel', [$pollenName, $test['value']]);

                if ($test['expectedLevel'] !== null) {
                    $this->assertIsString($result);
                    $this->assertEquals($test['expectedLevel'], $result);
                } else {
                    $this->assertNull($result);
                }
            });
        });

        // Test non-existing pollen type.
        $this->assertNull($this->invokeMethod($dto, 'getPollenLevel', ['MockedPollen', 0]));
    }
}