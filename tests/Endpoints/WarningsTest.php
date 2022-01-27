<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Endpoints;

use DateTime;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\Warning;
use Rugaard\DMI\Endpoints\Warnings;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Tests\AbstractTestCase;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;
use Tightenco\Collect\Support\Collection;

/**
 * Class WarningsTest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class WarningsTest extends AbstractTestCase
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
        $dmi = (new Client)->setClient($this->mockWarnings());

        // Get warnings data.
        $warnings = $dmi->warnings();

        // Assertions.
        $this->assertInstanceOf(Warnings::class, $warnings);
        $this->assertInstanceOf(Collection::class, $warnings->getData());
        $this->assertCount(2, $warnings->getData());
        $this->assertEquals('DMI risiko for kraftig regn og lokale skybrud', $warnings->getTitle());
        $this->assertEquals('Vest- og Sydsjælland samt Lolland-Falster, København og Nordsjælland, Østjylland og Nordjylland', $warnings->getArea());
        $this->assertInstanceOf(DateTime::class, $warnings->getIssued());
        $this->assertEquals('2019-02-25 10:58:00', $warnings->getIssued()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $warnings->getIssued()->getTimezone()->getName());
    }

    /**
     * Test empty warnings.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testEmptyWarnings() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockEmptyWarnings());

        // Get pollen data.
        $warnings = $dmi->warnings();

        // Assertions.
        $this->assertInstanceOf(Warnings::class, $warnings);
        $this->assertIsArray($warnings->getData());
        $this->assertCount(0, $warnings->getData());
    }

    /**
     * Test warning DTO.
     *
     * @return void
     * @throws \Rugaard\DMI\Exceptions\DMIException
     */
    public function testWarning() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockWarnings());

        // Get warnings data.
        $warnings = $dmi->warnings();

        // Get a single warning.
        /* @var $warning \Rugaard\DMI\DTO\Warning */
        $warning = $warnings->getData()->first();

        // Assertions.
        $this->assertInstanceOf(Warning::class, $warning);
        $this->assertEquals('DMI risiko for kraftig regn og lokale skybrud', $warning->getTitle());
        $this->assertEquals('DMI risiko for kraftig regn og lokale skybrud', $warning->getDescription());
        $this->assertEquals(
            'Vær opmærksom på, at lavtliggende områder som f.eks. kældre, vejbaner og viadukter kan oversvømmes. Store mængder vand påvirker trafikken, og der er risiko for strømafbrydelser. Tjek tagrender, nedløbsrør og afløbsriste nær din bolig. Luk vinduer og døre. Nedsæt hastigheden, mens du kører, for at undgå akvaplaning, og kør ikke ud i vand, hvor du ikke kan vurdere dybden.',
            $warning->getNote()
        );
        $this->assertEquals(
            'København og Nordsjælland, Midtsjælland og Odsherred',
            $warning->getArea()
        );
        $this->assertEquals('heavy-rain', $warning->getType());
        $this->assertEquals('low', $warning->getSeverity());
        $this->assertInstanceOf(DateTime::class, $warning->getIssuedAt());
        $this->assertEquals('2019-02-25 10:36:00', $warning->getIssuedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $warning->getIssuedAt()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $warning->getValidFrom());
        $this->assertEquals('2019-02-25 08:05:00', $warning->getValidFrom()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $warning->getValidFrom()->getTimezone()->getName());
        $this->assertInstanceOf(DateTime::class, $warning->getValidTo());
        $this->assertEquals('2019-02-25 13:00:00', $warning->getValidTo()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $warning->getValidTo()->getTimezone()->getName());
    }

    /**
     * Test warning types.
     *
     * @return void
     */
    public function testWarningTypes() : void
    {
        // Instantiate an empty warning DTO.
        $warning = new Warning;

        // Unknown type.
        $warning->setType('regnbue');
        $this->assertNull($warning->getType());

        // Heavy rain.
        $warning->setType('regn');
        $this->assertEquals('heavy-rain', $warning->getType());

        // Thunderstorm/Cloudburst.
        $warning->setType('konvektion');
        $this->assertEquals('thunderstorm-cloudburst', $warning->getType());

        // Heavy snow.
        $warning->setType('sne');
        $this->assertEquals('heavy-snow', $warning->getType());

        // Black ice.
        $warning->setType('isslag');
        $this->assertEquals('black-ice', $warning->getType());

        // Mist/Fog.
        $warning->setType('tage');
        $this->assertEquals('mist-fog', $warning->getType());

        // Heat wave.
        $warning->setType('temperatur');
        $this->assertEquals('heat-wave', $warning->getType());

        // Wind.
        $warning->setType('vind');
        $this->assertEquals('heavy-wind', $warning->getType());

        // Flooding.
        $warning->setType('forvand');
        $this->assertEquals('flooding', $warning->getType());
    }

    /**
     * Test warning severities.
     *
     * @return void
     */
    public function testWarningSeverities() : void
    {
        // Instantiate an empty warning DTO.
        $warning = new Warning;

        // Unknown severity.
        $warning->setSeverity(0);
        $this->assertNull($warning->getSeverity());

        // Low severity.
        $warning->setSeverity(1);
        $this->assertEquals('low', $warning->getSeverity());

        // Moderate severity.
        $warning->setSeverity(2);
        $this->assertEquals('moderate', $warning->getSeverity());

        // Severe severity.
        $warning->setSeverity(3);
        $this->assertEquals('severe', $warning->getSeverity());

        // Dangerous severity.
        $warning->setSeverity(4);
        $this->assertEquals('dangerous', $warning->getSeverity());
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

        // Get UV data.
        $dmi->warnings();
    }
}
