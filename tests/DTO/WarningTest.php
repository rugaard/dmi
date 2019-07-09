<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\DTO\Warning;
use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class WarningTest.
 *
 * @package Rugaard\DMI\Tests\DTO
 */
class WarningTest extends AbstractTestCase
{
    /**
     * Test set/get title.
     *
     * @return void
     */
    public function testTitle() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked title.
        $mockedTitle = 'Mocked title';

        // Set title.
        $dto->setTitle($mockedTitle);

        // Assertions.
        $this->assertIsString($dto->getTitle());
        $this->assertEquals($mockedTitle, $dto->getTitle());
    }

    /**
     * Test set/get description.
     *
     * @return void
     */
    public function testDescription() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked description.
        $mockedDescription = 'This is a mocked description.';

        // Set description.
        $dto->setDescription($mockedDescription);

        // Assertions.
        $this->assertIsString($dto->getDescription());
        $this->assertEquals($mockedDescription, $dto->getDescription());
    }

    /**
     * Test set/get note.
     *
     * @return void
     */
    public function testNote() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked note.
        $mockedNote = 'This is a mocked note.';

        // Set note.
        $dto->setNote($mockedNote);

        // Assertions.
        $this->assertIsString($dto->getNote());
        $this->assertEquals($mockedNote, $dto->getNote());
    }

    /**
     * Test set/get area.
     *
     * @return void
     */
    public function testArea() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked area.
        $mockedArea = 'Mocked area 1, Mocked area 2';

        // Set area.
        $dto->setArea($mockedArea);

        // Assertions.
        $this->assertIsString($dto->getArea());
        $this->assertEquals($mockedArea, $dto->getArea());
    }

    /**
     * Test set/get type.
     *
     * @return void
     */
    public function testType() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            'regn' => 'heavy-rain',
            'konvektion' => 'thunderstorm-cloudburst',
            'sne' => 'heavy-snow',
            'isslag' => 'black-ice',
            'tage' => 'mist-fog',
            'temperatur' => 'heat-wave',
            'vind' => 'heavy-wind',
            'forvand' => 'flooding',
        ]);

        // Test each supported warning type.
        $mockedData->each(function ($expectedType, $type) {
            // Instantiate empty DTO.
            $dto = new Warning;

            // Set type.
            $dto->setType($type);

            // Assertions.
            $this->assertIsString($dto->getType());
            $this->assertEquals($expectedType, $dto->getType());
        });

        // Test unsupported warning type.
        $dto = (new Warning)->setType('regnbue');
        $this->assertNull($dto->getType());
    }

    /**
     * Test set/get severity.
     *
     * @return void
     */
    public function testSeverity() : void
    {
        Collection::make(['low', 'moderate', 'severe', 'dangerous'])->each(function ($severity, $level) {
            // Instantiate empty DTO.
            $dto = new Warning;

            // Set severity.
            $dto->setSeverity($level + 1);

            // Assertions.
            $this->assertIsString($dto->getSeverity());
            $this->assertEquals($severity, $dto->getSeverity());
        });

        // Test unknown severity.
        $dto = (new Warning)->setSeverity(0);
        $this->assertNull($dto->getSeverity());
    }

    /**
     * Test set/get issued at.
     *
     * @return void
     * @throws \Exception
     */
    public function testIssuedAt() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked timestamp.
        $mockedTimestamp = '2019-06-30 08:00:05';

        // Set issued at.
        $dto->setIssuedAt(DateTime::createFromFormat('Y-m-d H:i:s', $mockedTimestamp, new DateTimeZone('Europe/Copenhagen'))->format('U') * 1000);

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getIssuedAt());
        $this->assertEquals($mockedTimestamp, $dto->getIssuedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getIssuedAt()->getTimezone()->getName());
    }

    /**
     * Test set/get valid from.
     *
     * @return void
     * @throws \Exception
     */
    public function testValidFrom() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked timestamp.
        $mockedTimestamp = '2019-06-30 10:30:00';

        // Set valid from.
        $dto->setValidFrom(DateTime::createFromFormat('Y-m-d H:i:s', $mockedTimestamp, new DateTimeZone('Europe/Copenhagen'))->format('U') * 1000);

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getValidFrom());
        $this->assertEquals($mockedTimestamp, $dto->getValidFrom()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getValidFrom()->getTimezone()->getName());
    }

    /**
     * Test set/get valid to.
     *
     * @return void
     * @throws \Exception
     */
    public function testValidTo() : void
    {
        // Instantiate empty DTO.
        $dto = new Warning;

        // Mocked timestamp.
        $mockedTimestamp = '2019-07-01 12:00:00';

        // Set valid to.
        $dto->setValidTo(DateTime::createFromFormat('Y-m-d H:i:s', $mockedTimestamp, new DateTimeZone('Europe/Copenhagen'))->format('U') * 1000);

        // Assertion.
        $this->assertInstanceOf(DateTime::class, $dto->getValidTo());
        $this->assertEquals($mockedTimestamp, $dto->getValidTo()->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Copenhagen', $dto->getValidTo()->getTimezone()->getName());
    }
}