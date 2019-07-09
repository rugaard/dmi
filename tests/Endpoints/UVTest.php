<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\DMI;
use Rugaard\DMI\Endpoints\UV;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class UVTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class UVTest extends AbstractTestCase
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
        $dmi = (new DMI)->setClient($this->mockUV());

        // Get UV data.
        $uv = $dmi->uv($this->mockedLocationId);

        // Assertions.
        $this->assertInstanceOf(UV::class, $uv);
        $this->assertInstanceOf(Collection::class, $uv->getData());
        $this->assertInstanceOf(DateTime::class, $uv->getData()->get('date'));
        $this->assertEquals('2019-06-30 02:00:00', $uv->getData()->get('date')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $uv->getData()->get('date')->getTimezone()->getName());
    }

    /**
     * Test basic details with global ID.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWithGlobalId() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = new DMI($this->mockedLocationId, $this->mockUV());

        // Get UV data.
        $uv = $dmi->uv();

        // Assertions.
        $this->assertInstanceOf(UV::class, $uv);
        $this->assertInstanceOf(Collection::class, $uv->getData());
        $this->assertInstanceOf(DateTime::class, $uv->getData()->get('date'));
        $this->assertEquals('2019-06-30 02:00:00', $uv->getData()->get('date')->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $uv->getData()->get('date')->getTimezone()->getName());
    }

    /**
     * Test without UV data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptyUV() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockEmptyUV());

        // Get UV data.
        $uv = $dmi->uv($this->mockedLocationId);

        // Assertions.
        $this->assertInstanceOf(UV::class, $uv);
        $this->assertIsArray($uv->getData());
        $this->assertCount(0, $uv->getData());
    }

    /**
     * Test UV data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testUV() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new DMI)->setClient($this->mockUV());

        //  Get UV (low to moderate) data.
        $uv = $dmi->uv($this->mockedLocationId);

        // Get UV data.
        $data = $uv->getData();

        // Assertions.
        $this->assertInstanceOf(Collection::class, $data);

        // Today value.
        $this->assertTrue($data->has('today'));
        $this->assertInstanceOf(Collection::class, $data->get('today'));
        $this->assertIsFloat($data->get('today')->get('value'));
        $this->assertEquals(5.6, $data->get('today')->get('value'));
        $this->assertEquals('Moderate', $data->get('today')->get('level'));

        // Peak value.
        $this->assertTrue($data->has('peak'));
        $this->assertInstanceOf(Collection::class, $data->get('peak'));
        $this->assertIsFloat($data->get('peak')->get('value'));
        $this->assertEquals(2.8, $data->get('peak')->get('value'));
        $this->assertEquals('Low', $data->get('peak')->get('level'));

        // Tomorrow value.
        $this->assertTrue($data->has('tomorrow'));
        $this->assertInstanceOf(Collection::class, $data->get('tomorrow'));
        $this->assertIsFloat($data->get('tomorrow')->get('value'));
        $this->assertEquals(5.5, $data->get('tomorrow')->get('value'));
        $this->assertEquals('Moderate', $data->get('tomorrow')->get('level'));

        // Get UV (high to extreme) data.
        $uv = $dmi->uv($this->mockedLocationId);

        // Get UV data.
        $data = $uv->getData();

        // Today value.
        $this->assertEquals(11.4, $data->get('today')->get('value'));
        $this->assertEquals('Extreme', $data->get('today')->get('level'));

        // Peak value.
        $this->assertEquals(6.2, $data->get('peak')->get('value'));
        $this->assertEquals('High', $data->get('peak')->get('level'));

        // Tomorrow value.
        $this->assertEquals(8.8, $data->get('tomorrow')->get('value'));
        $this->assertEquals('Very high', $data->get('tomorrow')->get('level'));
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

        // Get UV data.
        $dmi->uv($this->mockedLocationId);
    }
}