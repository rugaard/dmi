<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints\Archive;

use DateTime;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\Archive\Parameter;
use Rugaard\DMI\DTO\Archive\Value;
use Rugaard\DMI\DTO\Units\Bearing;
use Rugaard\DMI\DTO\Units\Time\Hour;
use Rugaard\DMI\DTO\Units\Length\Centimeter;
use Rugaard\DMI\DTO\Units\Length\Millimeter;
use Rugaard\DMI\DTO\Units\Percentage;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\Endpoints\Archive;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class MonthlyTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints\Archive
 */
class MonthlyTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Archive frequency.
     *
     * @var string|null
     */
    protected $frequency;

    /**
     * Archive period.
     *
     * @var string|null
     */
    protected $period;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Set archive frequency.
        $this->frequency = 'monthly';

        // Set archive period.
        $this->period = '2019-06';

        parent::setUp();
    }

    /**
     * Test monthly temperatures.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testTemperatures() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'temperature'));

        // Get archive data.
        $archive = $dmi->archive('temperature', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('temperature', $archive->getType());
        $this->assertEquals('monthly', $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Celsius::class, $archive->getUnit());
        $this->assertEquals('Celsius', $archive->getUnit()->getName());
        $this->assertEquals('°C', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(3, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds middeltemperatur', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(101, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/101/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(1.8721027374267578, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly wind.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWind() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'wind'));

        // Get archive data.
        $archive = $dmi->archive('wind', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('wind', $archive->getType());
        $this->assertEquals('monthly', $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(MetersPerSecond::class, $archive->getUnit());
        $this->assertEquals('Meters per second', $archive->getUnit()->getName());
        $this->assertEquals('m/s', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(3, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds middelvindhastighed', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(301, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/301/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(5.115189552307129, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly wind direction.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWindDirection() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'windDirection'));

        // Get archive data.
        $archive = $dmi->archive('wind-direction', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('wind-direction', $archive->getType());
        $this->assertEquals('monthly', $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Bearing::class, $archive->getUnit());
        $this->assertEquals('Bearing', $archive->getUnit()->getName());
        $this->assertEquals('°', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds middel vindretning', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(371, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/371/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(258.4704284667969, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly humidity.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testHumidity() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'humidity'));

        // Get archive data.
        $archive = $dmi->archive('humidity', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('humidity', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Percentage::class, $archive->getUnit());
        $this->assertEquals('Percentage', $archive->getUnit()->getName());
        $this->assertEquals('%', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds middel relativ luftfugtighed', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(201, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/201/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(86.81267547607422, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly pressure.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testPressure() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'pressure'));

        // Get archive data.
        $archive = $dmi->archive('pressure', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('pressure', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Hectopascal::class, $archive->getUnit());
        $this->assertEquals('Hectopascal', $archive->getUnit()->getName());
        $this->assertEquals('hPa', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds atmosfæretryk', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(401, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/401/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(1009.1738891601562, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly precipitation.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testPrecipitation() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'precipitation'));

        // Get archive data.
        $archive = $dmi->archive('precipitation', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('precipitation', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Millimeter::class, $archive->getUnit());
        $this->assertEquals('Millimeter', $archive->getUnit()->getName());
        $this->assertEquals('mm', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds akkumuleret nedbør', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(601, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/601/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(48.906192779541016, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly lightning.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testLightning() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'lightning'));

        // Get archive data.
        $archive = $dmi->archive('lightning', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('lightning', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertNull($archive->getUnit());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds antal lynnedslag', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(680, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/680/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(0.0, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly sun hours.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testSun() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'sun'));

        // Get archive data.
        $archive = $dmi->archive('sun', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('sun', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Hour::class, $archive->getUnit());
        $this->assertEquals('Hour', $archive->getUnit()->getName());
        $this->assertEquals('h', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds akkumuleret solskin', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(504, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/504/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(57.79069519042969, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly sun hours.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testDrought() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'drought'));

        // Get archive data.
        $archive = $dmi->archive('drought', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('drought', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertNull($archive->getUnit());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds tørkeindeks', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(212, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(6, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/212/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(0.03249435424804688, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test monthly snow.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testSnow() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockArchive($this->frequency, 'snow'));

        // Get archive data.
        $archive = $dmi->archive('snow', $this->frequency, $this->period);

        // Assert basics.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertEquals('snow', $archive->getType());
        $this->assertEquals($this->frequency, $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-06-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Centimeter::class, $archive->getUnit());
        $this->assertEquals('Centimeter', $archive->getUnit()->getName());
        $this->assertEquals('cm', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Måneds snedybde', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(906, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(4, $parameter->getValues());
        $this->assertEquals('https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/year/906/interpolated_1/2019.png', $parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(21.0, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test empty monthly archive data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptyArchiveData() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyArchive());

        // Get archive data-
        $archive = $dmi->archive('temperature', $this->frequency, $this->period);

        // Assertions.
        $this->assertInstanceOf(Archive::class, $archive);
        $this->assertIsArray($archive->getData());
        $this->assertCount(0, $archive->getData());
    }
}
