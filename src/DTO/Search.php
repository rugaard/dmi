<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

/**
 * Class Search
 *
 * @package Rugaard\DMI\DTO
 */
class Search extends AbstractDTO
{
    /**
     * ID of location.
     *
     * @var int|null
     */
    protected $id;

    /**
     * Name of location.
     *
     * @var string|null
     */
    protected $name;

    /**
     * Population of location.
     *
     * @var int|null
     */
    protected $population;

    /**
     * Municipality of location.
     *
     * @var string|null
     */
    protected $municipality;

    /**
     * Country of location.
     *
     * @var string|null
     */
    protected $country;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->setId((int) $data['id'])
             ->setName($data['name_ngram'])
             ->setPopulation(!empty($data['population']) ? (int) $data['population'] : null)
             ->setMunicipality($data['municipality'])
             ->setCountry($data['countryname']);
    }

    /**
     * Set location ID.
     *
     * @param  int $id
     * @return $this
     */
    public function setId(int $id) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get location ID.
     *
     * @return int|null
     */
    public function getId() :? int
    {
        return $this->id;
    }

    /**
     * Set location name.
     *
     * @param  string $name
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get location name.
     *
     * @return string|null
     */
    public function getName() :? string
    {
        return $this->name;
    }

    /**
     * Set location population.
     *
     * @param  int|null $population
     * @return $this
     */
    public function setPopulation(?int $population) : self
    {
        $this->population = $population;
        return $this;
    }

    /**
     * Get location population.
     *
     * @return int|null
     */
    public function getPopulation() :? int
    {
        return $this->population;
    }

    /**
     * Set location municipality.
     *
     * @param  string $municipality
     * @return \Rugaard\DMI\DTO\Search
     */
    public function setMunicipality(string $municipality) : self
    {
        $this->municipality = $municipality;
        return $this;
    }

    /**
     * Get location municipality.
     *
     * @return string|null
     */
    public function getMunicipality() :? string
    {
        return $this->municipality;
    }

    /**
     * Set location country.
     *
     * @param  string $country
     * @return \Rugaard\DMI\DTO\Search
     */
    public function setCountry(string $country) : self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get location country,
     *
     * @return string|null
     */
    public function getCountry() :? string
    {
        return $this->country;
    }
}