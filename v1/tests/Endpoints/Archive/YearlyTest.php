<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Endpoints\Archive;

use DateTime;
use Rugaard\DMI\Old\Client;
use Rugaard\DMI\Old\DTO\Archive\Parameter;
use Rugaard\DMI\Old\DTO\Archive\Value;
use Rugaard\DMI\Old\DTO\Units\Bearing;
use Rugaard\DMI\Old\DTO\Units\Time\Hour;
use Rugaard\DMI\Old\DTO\Units\Length\Centimeter;
use Rugaard\DMI\Old\DTO\Units\Length\Millimeter;
use Rugaard\DMI\Old\DTO\Units\Percentage;
use Rugaard\DMI\Old\DTO\Units\Pressure\Hectopascal;
use Rugaard\DMI\Old\DTO\Units\Speed\MetersPerSecond;
use Rugaard\DMI\Old\DTO\Units\Temperature\Celsius;
use Rugaard\DMI\Old\Endpoints\Archive;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Rugaard\DMI\Old\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class ArchiveTest.
 *
 * @package Rugaard\DMI\Old\Tests\Endpoints\Archive
 */
class YearlyTest extends AbstractTestCase
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
        $this->frequency = 'yearly';

        // Set archive period.
        $this->period = '2019';

        parent::setUp();
    }

    /**
     * Test yearly temperatures.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('yearly', $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Celsius::class, $archive->getUnit());
        $this->assertEquals('Celsius', $archive->getUnit()->getName());
        $this->assertEquals('°C', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(3, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års middeltemperatur', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(101, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(8.940168380737305, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly wind.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('yearly', $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(MetersPerSecond::class, $archive->getUnit());
        $this->assertEquals('Meters per second', $archive->getUnit()->getName());
        $this->assertEquals('m/s', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(3, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års middelvindhastighed', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(301, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(4.885385990142822, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly wind direction.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('yearly', $archive->getFrequency());
        $this->assertInstanceOf(DateTime::class, $archive->getPeriod());
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Bearing::class, $archive->getUnit());
        $this->assertEquals('Bearing', $archive->getUnit()->getName());
        $this->assertEquals('°', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års middel vindretning', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(371, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(219.5497283935547, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly humidity.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Percentage::class, $archive->getUnit());
        $this->assertEquals('Percentage', $archive->getUnit()->getName());
        $this->assertEquals('%', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års middel relativ luftfugtighed', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(201, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(84.35615539550781, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly pressure.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Hectopascal::class, $archive->getUnit());
        $this->assertEquals('Hectopascal', $archive->getUnit()->getName());
        $this->assertEquals('hPa', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års atmosfæretryk', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(401, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(1014.3287963867188, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly precipitation.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Millimeter::class, $archive->getUnit());
        $this->assertEquals('Millimeter', $archive->getUnit()->getName());
        $this->assertEquals('mm', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års akkumuleret nedbør', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(601, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(782.6932373046875, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly lightning.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertNull($archive->getUnit());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års antal lynnedslag', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(680, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(27061.0, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly sun hours.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Hour::class, $archive->getUnit());
        $this->assertEquals('Hour', $archive->getUnit()->getName());
        $this->assertEquals('h', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års akkumuleret solskin', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(504, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(9, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(1680.810302734375, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2011-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly sun hours.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertNull($archive->getUnit());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års tørkeindeks', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(212, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(3, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(1.7036354064941406, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2017-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test yearly snow.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
        $this->assertEquals('2019-01-01 02:00:00', $archive->getPeriod()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $archive->getPeriod()->getTimezone()->getName());
        $this->assertEquals('Hele landet', $archive->getArea());
        $this->assertInstanceOf(Centimeter::class, $archive->getUnit());
        $this->assertEquals('Centimeter', $archive->getUnit()->getName());
        $this->assertEquals('cm', $archive->getUnit()->getAbbreviation());
        $this->assertInstanceOf(Collection::class, $archive->getData());
        $this->assertCount(1, $archive->getData());

        // Assert parameters.
        /* @var $parameter \Rugaard\DMI\Old\DTO\Archive\Parameter */
        $parameter = $archive->getData()->first();
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals('Års snedybde', $parameter->getTitle());
        $this->assertIsInt($parameter->getParameterId());
        $this->assertEquals(906, $parameter->getParameterId());
        $this->assertInstanceOf(Collection::class, $parameter->getValues());
        $this->assertCount(1, $parameter->getValues());
        $this->assertNull($parameter->getImageUrl());

        // Assert values.
        /* @var $value \Rugaard\DMI\Old\DTO\Archive\Value */
        $value = $parameter->getValues()->first();
        $this->assertInstanceOf(Value::class, $value);
        $this->assertIsFloat($value->getValue());
        $this->assertEquals(21.0, $value->getValue());
        $this->assertInstanceOf(DateTime::class, $value->getTimestamp());
        $this->assertEquals('2019-01-01 01:00:00', $value->getTimestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $value->getTimestamp()->getTimezone()->getName());
    }

    /**
     * Test empty yearly archive data.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
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
