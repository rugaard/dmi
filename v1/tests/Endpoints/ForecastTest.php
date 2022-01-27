<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\Old\Client;
use Rugaard\DMI\Old\DTO\Forecast\Text;
use Rugaard\DMI\Old\Exceptions\DMIException;
use Rugaard\DMI\Old\Tests\AbstractTestCase;
use Rugaard\DMI\Old\Tests\Support\MockedResponses\MockedResponses;

/**
 * Class ForecastTest.
 *
 * @package Rugaard\DMI\Old\Tests\Endpoints
 */
class ForecastTest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Test basic details.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
     */
    public function testBasics() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockForecast());

        // Get forecast.
        $forecast = $dmi->forecast();

        // Assertions.
        $this->assertInstanceOf(Text::class, $forecast);
        $this->assertEquals('Udsigt for hele Danmark', $forecast->getTitle());
        $this->assertEquals(
            'Lidt og nogen sol, men også spredte byger, især på Sjælland og i nordøstlige Jylland. Bygerne kan lokalt være med torden. Temp. op mellem 17 og 21 grader, ved Vestkysten omkring 15 grader. I nat mest tørt og klart vejr, men i den sydvestlige del af landet antageligt mere skyet. Temp. ned mellem 8 og 13 grader. Hele døgnet svag til frisk vind fra vest og nordvest, ved Vestkysten stedvis op til hård vind.',
            $forecast->getText()
        );
        $this->assertEquals('Mandag den 8. juli 2019.', $forecast->getDate());
        $this->assertEquals('Udsigt, der gælder til tirsdag morgen, udsendt kl. 11.00', $forecast->getValidity());
        $this->assertInstanceOf(DateTime::class, $forecast->getIssuedAt());
        $this->assertEquals('2019-07-08 11:03:15', $forecast->getIssuedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $forecast->getIssuedAt()->getTimezone()->getName());
    }

    /**
     * Test failed request by coordinate.
     *
     * @return void
     * @throws \Rugaard\DMI\Old\Exceptions\DMIException
     */
    public function testFailedRequest() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockInternalErrorRequest());

        // Assert expectation of exception.
        $this->expectException(DMIException::class);

        // Get forecast.
        $dmi->forecast();
    }
}
