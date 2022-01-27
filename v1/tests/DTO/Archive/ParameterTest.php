<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO\Archive;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\Old\DTO\Archive\Parameter;
use Rugaard\DMI\Old\DTO\Archive\Value;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class ParameterTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO\Archive
 */
class ParameterTest extends AbstractTestCase
{
    /**
     * Mocked parameter ID.
     *
     * @var int|null
     */
    protected $mockedParameterId;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Mocked parameter ID.
        $this->mockedParameterId = 100;

        parent::setUp();
    }

    /**
     * Test set/get title.
     *
     * @return void
     */
    public function testTitle() : void
    {
        // Instantiate empty DTO.
        $dto = new Parameter($this->mockedParameterId);

        // Mocked title
        $mockedTitle = 'This is mocked parameter group';

        // Set title.
        $dto->setTitle($mockedTitle);

        // Assertions
        $this->assertIsString($dto->getTitle());
        $this->assertEquals($mockedTitle, $dto->getTitle());
    }

    /**
     * Test set/get parameter ID.
     *
     * @return void
     */
    public function testParameterId() : void
    {
        // Instantiate empty DTO.
        $dto = new Parameter($this->mockedParameterId);

        // Assert initial parameter ID.
        $this->assertIsInt($dto->getParameterId());
        $this->assertEquals($this->mockedParameterId, $dto->getParameterId());

        // Mocked parameter ID.
        $mockedParameterId = 287;

        // Set title.
        $dto->setParameterId($mockedParameterId);

        // Assertions
        $this->assertIsInt($dto->getParameterId());
        $this->assertEquals($mockedParameterId, $dto->getParameterId());
    }

    /**
     * Test set/get values.
     *
     * @return void
     */
    public function testValues() : void
    {
        // Instantiate empty DTO.
        $dto = new Parameter($this->mockedParameterId);

        // Mocked test data.
        $mockedData = json_decode(file_get_contents(__DIR__ . '/../../Support/MockedResponses/JSON/Archive/Daily/Temperature.json'), true)[0]['dataserie'];

        // Set title.
        $dto->setValues($mockedData);

        // Assertions
        $this->assertInstanceOf(Collection::class, $dto->getValues());
        $this->assertCount(30, $dto->getValues());
        $this->assertInstanceOf(Value::class, $dto->getValues()->first());
    }

    /**
     * Test set/get image URL by parameter ID.
     *
     * @return void
     */
    public function testImageUrl() : void
    {
        // Mocked timestamp.
        $mockedTimestamp = DateTime::createFromFormat('Y-m-d H:i:s', '2019-06-30 02:00:00', new DateTimeZone('Europe/Copenhagen'));

        // Mocked test data.
        $mockedData = Collection::make([
            [
                'frequency' => 'hourly',
                'expectedUrl' => 'https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/day/' . $this->mockedParameterId . '/interpolated_1/2019/06/20190630.png',
            ], [
                'frequency' => 'daily',
                'expectedUrl' => 'https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/month/' . $this->mockedParameterId . '/interpolated_1/2019/201906.png',
            ], [
                'frequency' => 'monthly',
                'expectedUrl' => 'https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/' . $this->mockedParameterId . '/interpolated_1/2019.png',
            ], [
                'frequency' => 'yearly',
                'expectedUrl' => null,
            ]
        ]);

        $mockedData->each(function ($data) use ($mockedTimestamp) {
            // Instantiate empty DTO.
            $dto = new Parameter($this->mockedParameterId);

            // Set image URL.
            $dto->setImageUrl($data['frequency'], $mockedTimestamp);

            // If frequency is "yearly",
            // then we need to assert a little bit different.
            if ($data['frequency'] === 'yearly') {
                $this->assertNull($dto->getImageUrl());
                return;
            }

            // Assertions.
            $this->assertIsString($dto->getImageUrl());
            $this->assertNotFalse(filter_var($dto->getImageUrl(), FILTER_VALIDATE_URL));
            $this->assertEquals($data['expectedUrl'], $dto->getImageUrl());
        });
    }
}
