<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements\Wind;

use Rugaard\DMI\DTO\AbstractDTO;

/**
 * Class Direction.
 *
 * @package Rugaard\DMI\DTO\Measurements\Wind
 */
class Direction extends AbstractDTO
{
    /**
     * Wind direction.
     *
     * @var string|null
     */
    protected $direction;

    /**
     * Wind direction abbreviation.
     *
     * @var string|null
     */
    protected $abbreviation;

    /**
     * Wind degrees.
     *
     * @var float|null
     */
    protected $degrees;

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->setDegreesAndDirection((float) $data['windDegree']);
    }

    /**
     * Set degrees and direction.
     *
     * @param  float $degrees
     * @return $this
     */
    public function setDegreesAndDirection(float $degrees) : self
    {
        $this->setDegrees($degrees)->setDirectionByDegrees($degrees);
        return $this;
    }

    /**
     *
     * @param  float|null $degrees
     * @return \Rugaard\DMI\DTO\Measurements\Wind\Direction
     */
    public function setDirectionByDegrees(?float $degrees) : self
    {
        if ($degrees < 360 && $degrees > 337.5) {
            $this->setDirection('N');
        } elseif ($degrees > 292.5) {
            $this->setDirection('NW');
        } elseif ($degrees > 247.5) {
            $this->setDirection('V');
        } elseif ($degrees > 202.5) {
            $this->setDirection('SW');
        } elseif ($degrees > 157.5) {
            $this->setDirection('S');
        } elseif ($degrees > 112.5) {
            $this->setDirection('SE');
        } elseif ($degrees > 67.5) {
            $this->setDirection('E');
        } elseif ($degrees > 22.5) {
            $this->setDirection('NE');
        } elseif ($degrees >= 0) {
            $this->setDirection('N');
        }
        return $this;
    }

    /**
     * Set wind direction.
     *
     * @param  string|null $direction
     * @return $this
     */
    public function setDirection(?string $direction) : self
    {
        switch ($direction) {
            case 'N':
                $this->direction = 'North';
                $this->setAbbreviation('N');
                break;
            case 'S':
                $this->direction = 'South';
                $this->setAbbreviation('S');
                break;
            case 'Ø':
            case 'E':
                $this->direction = 'East';
                $this->setAbbreviation('E');
                break;
            case 'V':
            case 'W':
                $this->direction = 'West';
                $this->setAbbreviation('W');
                break;
            case 'NØ':
            case 'NE':
                $this->direction = 'Northeast';
                $this->setAbbreviation('NE');
                break;
            case 'NV':
            case 'NW':
                $this->direction = 'Northwest';
                $this->setAbbreviation('NW');
                break;
            case 'SØ':
            case 'SE':
                $this->direction = 'Southeast';
                $this->setAbbreviation('SE');
                break;
            case 'SV':
            case 'SW':
                $this->direction = 'Southwest';
                $this->setAbbreviation('SW');
                break;
            case 'NNØ':
            case 'NNE':
                $this->direction = 'North-northeast';
                $this->setAbbreviation('NNE');
                break;
            case 'NNV':
            case 'NNW':
                $this->direction = 'North-northwest';
                $this->setAbbreviation('NNW');
                break;
            case 'ØNØ':
            case 'ENE':
                $this->direction = 'East-northeast';
                $this->setAbbreviation('ENE');
                break;
            case 'ØSØ':
            case 'ESE':
                $this->direction = 'East-southeast';
                $this->setAbbreviation('ESE');
                break;
            case 'SSØ':
            case 'SSE':
                $this->direction = 'South-southeast';
                $this->setAbbreviation('SSE');
                break;
            case 'SSV':
            case 'SSW':
                $this->direction = 'South-southwest';
                $this->setAbbreviation('SSV');
                break;
            case 'VNV':
            case 'WNW':
                $this->direction = 'West-northwest';
                $this->setAbbreviation('WNW');
                break;
            case 'VSV':
            case 'WSW':
                $this->direction = 'West-southwest';
                $this->setAbbreviation('WSW');
                break;
        }
        return $this;
    }

    /**
     * Get wind direction.
     *
     * @return string|null
     */
    public function getDirection() :? string
    {
        return $this->direction;
    }

    /**
     * Set wind direction abbreviation.
     *
     * @param  string $abbreviation
     * @return \Rugaard\DMI\DTO\Measurements\Wind\Direction
     */
    public function setAbbreviation(string $abbreviation) : self
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    /**
     * Get wind direction abbreviation.
     *
     * @return string|null
     */
    public function getAbbreviation() :? string
    {
        return $this->abbreviation;
    }

    /**
     * Set wind degrees.
     *
     * @param  float|null $degrees
     * @return $this
     */
    public function setDegrees(?float $degrees) : self
    {
        $this->degrees = $degrees !== null ? (float) $degrees : null;
        return $this;
    }

    /**
     * Get wind degrees.
     *
     * @return float|null
     */
    public function getDegrees() :? float
    {
        return $this->degrees;
    }

    /**
     * __toString().
     *
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->getDirection();
    }
}