<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Tests\DTO;

use Rugaard\DMI\Old\DTO\Search;
use Rugaard\DMI\Old\Tests\AbstractTestCase;

/**
 * Class SearchTest.
 *
 * @package Rugaard\DMI\Old\Tests\DTO
 */
class SearchTest extends AbstractTestCase
{
    /**
     * Test set/get ID.
     *
     * @return void
     */
    public function testId() : void
    {
        // Instantiate empty DTO.
        $dto = new Search;

        // Mocked ID.
        $mockedId = 12345678;

        // Set ID.
        $dto->setId($mockedId);

        // Assertion.
        $this->assertIsInt($dto->getId());
        $this->assertEquals($mockedId, $dto->getId());
    }

    /**
     * Test set/get name.
     *
     * @return void
     */
    public function testName() : void
    {
        // Instantiate empty DTO.
        $dto = new Search;

        // Mocked name.
        $mockedName = 'Mocked name';

        // Set name.
        $dto->setName($mockedName);

        // Assertion.
        $this->assertIsString($dto->getName());
        $this->assertEquals($mockedName, $dto->getName());
    }

    /**
     * Test set/get population.
     *
     * @return void
     */
    public function testPopulation() : void
    {
        // Instantiate empty DTO.
        $dto = new Search;

        // Mocked population.
        $mockedPopulation = 68712;

        // Set population.
        $dto->setPopulation($mockedPopulation);

        // Assertion.
        $this->assertIsInt($dto->getPopulation());
        $this->assertEquals($mockedPopulation, $dto->getPopulation());
    }

    /**
     * Test set/get municipality.
     *
     * @return void
     */
    public function testMunicipality() : void
    {
        // Instantiate empty DTO.
        $dto = new Search;

        // Mocked municipality.
        $mockedMunicipality = 'Mocked name';

        // Set municipality.
        $dto->setMunicipality($mockedMunicipality);

        // Assertion.
        $this->assertIsString($dto->getMunicipality());
        $this->assertEquals($mockedMunicipality, $dto->getMunicipality());
    }

    /**
     * Test set/get country.
     *
     * @return void
     */
    public function testCountry() : void
    {
        // Instantiate empty DTO.
        $dto = new Search;

        // Mocked country.
        $mockedCountry = 'Mocked country';

        // Set country.
        $dto->setCountry($mockedCountry);

        // Assertion.
        $this->assertIsString($dto->getCountry());
        $this->assertEquals($mockedCountry, $dto->getCountry());
    }
}
