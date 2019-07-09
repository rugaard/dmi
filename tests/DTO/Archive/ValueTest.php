<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\DTO\Archive;

use DateTime;
use Rugaard\DMI\DTO\Archive\Value;
use Rugaard\DMI\Tests\AbstractTestCase;

/**
 * Class ValueTest.
 *
 * @package Rugaard\DMI\Tests\DTO\Archive
 */
class ValueTest extends AbstractTestCase
{
    /**
     * Test set/get value.
     *
     * @return void
     */
    public function testValue() : void
    {
        // Instantiate empty DTO.
        $dto = new Value;

        // Mocked value
        $mockedValue = 15.111984;

        // Set value.
        $dto->setValue($mockedValue);

        // Assertions
        $this->assertIsFloat($dto->getValue());
        $this->assertEquals($mockedValue, $dto->getValue());
    }

    /**
     * Test set/get timestamp.
     *
     * @return void
     */
    public function testTimestamp() : void
    {
        // Instantiate empty DTO.
        $dto = new Value;

        // Mocked timestamp.
        $mockedTimestamp = '30-06-2019 12:00';

        // Set timestamp.
        $dto->setTimestamp($mockedTimestamp);

        // Assertions.
        $this->assertInstanceOf(DateTime::class, $dto->getTimestamp());
        $this->assertEquals($mockedTimestamp, $dto->getTimestamp()->format('d-m-Y H:i'));
        $this->assertEquals('Europe/Copenhagen', $dto->getTimestamp()->getTimezone()->getName());
    }
}