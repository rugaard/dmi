<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\DMI;
use Rugaard\DMI\DTO\Pollen as PollenDTO;
use Rugaard\DMI\Endpoints\Pollen;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class PollenTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class PollenTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Mocked location ID.
     *
     * @var int|null
     */
    protected $mockedLocationId;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Set a mocked location ID.
        $this->mockedLocationId = 2618425;

        parent::setUp();
    }

    /**
     * Test basic details.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testBasics() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockPollen());

        // Get UV data.
        $pollen = $dmi->pollen();

        // Assertions.
        $this->assertInstanceOf(Pollen::class, $pollen);
        $this->assertInstanceOf(Collection::class, $pollen->getData());

        // Regions.
        $this->assertTrue($pollen->getData()->has('regions'));
        $this->assertInstanceOf(Collection::class, $pollen->getData()->get('regions'));
        $this->assertCount(2, $pollen->getData()->get('regions'));

        // Meta.
        $this->assertTrue($pollen->getData()->has('meta'));
        $this->assertInstanceOf(Collection::class, $pollen->getData()->get('meta'));
        $this->assertInstanceOf(DateTime::class, $pollen->getData()->get('meta')->get('timestamp'));
        $this->assertEquals('2019-07-02 16:45:04', $pollen->getData()->get('meta')->get('timestamp')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $pollen->getData()->get('meta')->get('timestamp')->getTimezone()->getName());
        $this->assertEquals('Kilde: Astma-Allergi Danmark og DMI', $pollen->getData()->get('meta')->get('comment'));
        $this->assertEquals(
            'Pollentallet er det gennemsnitlige antal pollen pr. kubikmeter luft pr. døgn, i København målt i tidsrummet i går kl. 13 til i dag kl. 13, i Viborg målt i tidsrummet i går kl. 9 til i dag kl. 9. Pollentallet måles 15 m over jordniveau.',
            $pollen->getData()->get('meta')->get('info')
        );
        $this->assertEquals(
            'Dagens pollental og pollenvarsling er fra Astma- og Allergiforbundet og Danmarks Meteorologiske Institut.',
            $pollen->getData()->get('meta')->get('copyright')
        );
    }

    /**
     * Test without pollen data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptyPollen() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockEmptyPollen());

        // Get pollen data.
        $pollen = $dmi->pollen();

        // Assertions.
        $this->assertInstanceOf(Pollen::class, $pollen);
        $this->assertIsArray($pollen->getData());
        $this->assertCount(0, $pollen->getData());
    }

    /**
     * Test regions.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testRegions() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockPollen());

        // Get pollen data.
        $pollen = $dmi->pollen();

        // Assertions.
        $regions = $pollen->getData()->get('regions');
        $this->assertInstanceOf(Collection::class, $regions);
        $this->assertCount(2, $regions);
        $this->assertTrue($regions->has('east'));
        $this->assertTrue($regions->has('west'));

        // Region data.
        /* @var $dto \Rugaard\DMI\DTO\Pollen */
        $dto = $regions->first();
        $this->assertInstanceOf(PollenDTO::class, $dto);
        $this->assertEquals('København', $dto->getName());
        $this->assertInstanceOf(Collection::class, $dto->getReadings());
        $this->assertEquals(
            'For i morgen, onsdag d. 3 juli, ventes et moderat antal græspollen, mellem 10-50 pr. m3 luft',
            $dto->getForecast()
        );
    }

    /**
     * Test pollen readings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testReadings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockPollen());

        // Get pollen data.
        $pollen = $dmi->pollen();

        // Get pollen region.
        /* @var $region \Rugaard\DMI\DTO\Pollen */
        $region = $pollen->getData()->get('regions')->first();

        // Get pollen region readings.
        $readings = $region->getReadings();

        // Assertions.
        $this->assertInstanceOf(Collection::class, $readings);
        $this->assertCount(8, $readings);
        $readings->each(function ($reading, $key) {
            switch ($key) {
                case 0:
                    $this->assertEquals('Birk', $reading->get('name'));
                    $this->assertIsInt($reading->get('value'));
                    $this->assertEquals(0, $reading->get('value'));
                    $this->assertNull($reading->get('level'));
                    break;
                case 1:
                    $this->assertEquals('Bynke', $reading->get('name'));
                    $this->assertIsInt($reading->get('value'));
                    $this->assertEquals(0, $reading->get('value'));
                    $this->assertNull($reading->get('level'));
                    break;
                case 2:
                    $this->assertEquals('El', $reading->get('name'));
                    $this->assertIsInt($reading->get('value'));
                    $this->assertEquals(0, $reading->get('value'));
                    $this->assertNull($reading->get('level'));
                    break;
                case 3:
                    $this->assertEquals('Elm', $reading->get('name'));
                    $this->assertIsInt($reading->get('value'));
                    $this->assertEquals(51, $reading->get('value'));
                    $this->assertEquals('High', $reading->get('level'));
                    break;
                case 4:
                    $this->assertEquals('Græs', $reading->get('name'));
                    $this->assertIsInt($reading->get('value'));
                    $this->assertEquals(18, $reading->get('value'));
                    $this->assertEquals('Moderate', $reading->get('level'));
                    break;
                case 5:
                    $this->assertEquals('Hassel', $reading->get('name'));
                    $this->assertIsInt($reading->get('value'));
                    $this->assertEquals(0, $reading->get('value'));
                    $this->assertNull($reading->get('level'));
                    break;
                case 6:
                    $this->assertEquals('Alternaria', $reading->get('name'));
                    $this->assertNull($reading->get('value'));
                    $this->assertEquals('Moderate', $reading->get('level'));
                    break;
                case 7:
                    $this->assertEquals('Cladosporium', $reading->get('name'));
                    $this->assertNull($reading->get('value'));
                    $this->assertEquals('Low', $reading->get('level'));
                    break;
            }
        });
    }

    /**
     * Test failed request.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testFailedRequest() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockInternalErrorRequest());

        // Assert expectation of exception.
        $this->expectException(DMIException::class);

        // Get pollen data.
        $dmi->pollen();
    }
}
