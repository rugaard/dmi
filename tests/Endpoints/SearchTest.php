<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use Rugaard\DMI\Client;
use Rugaard\DMI\Endpoints\Search;
use Rugaard\DMI\DTO\Search as SearchDTO;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class SearchTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class SearchTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Mocked query.
     *
     * @var string|null
     */
    protected $mockedQuery;

    /**
     * Prepare test cases.
     *
     * @return void
     */
    public function setUp() : void
    {
        // Set a mocked query.
        $this->mockedQuery = 'Sundby';

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
        $dmi = (new Client)->setClient($this->mockSearch());

        // Get search data.
        $search = $dmi->search($this->mockedQuery);

        // Assertions.
        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(Collection::class, $search->getData());
        $this->assertCount(13, $search->getData());
    }

    /**
     * Test basic details without data.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptySearch() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptySearch());

        // Get search data.
        $search = $dmi->search($this->mockedQuery);

        // Assertions.
        $this->assertInstanceOf(Search::class, $search);
        $this->assertIsArray($search->getData());
        $this->assertCount(0, $search->getData());
    }

    /**
     * Test basic details.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testResult() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockSearch());

        // Get search data.
        $search = $dmi->search($this->mockedQuery);

        // Get first match from search result.
        /* @var $location \Rugaard\DMI\DTO\Search */
        $location = $search->getData()->first();

        // Assertions.
        $this->assertInstanceOf(SearchDTO::class, $location);
        $this->assertIsInt($location->getId());
        $this->assertEquals(2612121, $location->getId());
        $this->assertIsString($location->getName());
        $this->assertEquals('Sundby', $location->getName());
        $this->assertIsInt($location->getPopulation());
        $this->assertEquals(2922, $location->getPopulation());
        $this->assertIsString($location->getMunicipality());
        $this->assertEquals('Guldborgsund', $location->getMunicipality());
        $this->assertIsString($location->getCountry());
        $this->assertEquals('Danmark', $location->getCountry());
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
        $dmi = (new Client)->setClient($this->mockInternalErrorRequest());

        // Assert expectation of exception.
        $this->expectException(DMIException::class);

        // Get search data.
        $dmi->search($this->mockedQuery);
    }
}
