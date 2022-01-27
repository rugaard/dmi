<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\Forecast\Text;
use Rugaard\DMI\Endpoints\Forecast;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class ExtendedForecastTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class ExtendedForecastTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Test basic details.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testBasics() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockExtendedForecast());

        // Get extended forecast.
        $forecast = $dmi->extendedForecast();

        // Assertions.
        $this->assertInstanceOf(Forecast::class, $forecast);
        $this->assertEquals('I ugens løb lidt lunere', $forecast->getTitle());
        $this->assertEquals(
            'Kølig luft med byger strømmer ned over Danmark fra nordvest. Onsdag ventes et svagt højtryk en kort overgang at ligge lige vest eller sydvest for Danmark, men det bevæger sig langsomt mod sydøst. Torsdag og fredag bevæger et svagt lavtryksområde sig ned over Centraleuropa fra nordvest.',
            $forecast->getText()
        );
        $this->assertEquals('Mandag den 8. juli 2019.', $forecast->getDate());
        $this->assertEquals('Udsigten er ret sikker, dog er det usikkert hvor meget nedbør den østlige del af landet vi får frem til mandag aften.', $forecast->getUncertainty());
        $this->assertInstanceOf(DateTime::class, $forecast->getIssuedAt());
        $this->assertEquals('2019-07-08 11:32:49', $forecast->getIssuedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $forecast->getIssuedAt()->getTimezone()->getName());
    }

    /**
     * Test days in extended forecast.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testDays() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockExtendedForecast());

        // Get extended forecast.
        $forecast = $dmi->extendedForecast();

        // Assertions.
        $this->assertInstanceOf(Forecast::class, $forecast);
        $this->assertInstanceOf(Collection::class, $forecast->getData());
        $this->assertCount(6, $forecast->getData());

        // Get first day.
        $day = $forecast->getData()->first();
        $this->assertInstanceOf(Collection::class, $day);
        $this->assertEquals('Tirsdag', $day->get('title'));
        $this->assertEquals(
            'Nogen eller en del sol de fleste steder, men også enkelte byger, og i den sydvestlige del af landet kan det være skyet en stor del af dagen. Temp. op mellem 17 og 21 grader, lidt køligere ved Vestkysten. Svag til frisk vind fra nordvest og vest, ved Vestkysten stedvis hård vind. Om natten mest tørt og ret klart vejr. Temp. mellem 8 og 13 grader, og svag til jævn nordvestlig vind.',
            $day->get('text')
        );
    }

    /**
     * Test failed request by coordinate.
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

        // Get extended forecast.
        $dmi->extendedForecast();
    }
}
