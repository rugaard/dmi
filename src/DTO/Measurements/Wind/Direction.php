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
    protected $degrees = 0.0;

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
            $this->setDirection('NV');
        } elseif ($degrees > 247.5) {
            $this->setDirection('V');
        } elseif ($degrees > 202.5) {
            $this->setDirection('SV');
        } elseif ($degrees > 157.5) {
            $this->setDirection('S');
        } elseif ($degrees > 112.5) {
            $this->setDirection('SØ');
        } elseif ($degrees > 67.5) {
            $this->setDirection('Ø');
        } elseif ($degrees > 22.5) {
            $this->setDirection('NØ');
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
                $this->direction = 'Nord';
                $this->setAbbreviation('N');
                break;
            case 'S':
                $this->direction = 'Syd';
                $this->setAbbreviation('S');
                break;
            case 'Ø':
                $this->direction = 'Øst';
                $this->setAbbreviation('Ø');
                break;
            case 'V':
                $this->direction = 'Vest';
                $this->setAbbreviation('V');
                break;
            case 'NØ':
                $this->direction = 'Nordøst';
                $this->setAbbreviation('NØ');
                break;
            case 'NV':
                $this->direction = 'Nordvest';
                $this->setAbbreviation('NV');
                break;
            case 'SØ':
                $this->direction = 'Sydøst';
                $this->setAbbreviation('SØ');
                break;
            case 'SV':
                $this->direction = 'Sydvest';
                $this->setAbbreviation('SV');
                break;
            case 'NNØ':
                $this->direction = 'Nord-nordøst';
                $this->setAbbreviation('NNØ');
                break;
            case 'NNV':
                $this->direction = 'Nord-nordvest';
                $this->setAbbreviation('NNV');
                break;
            case 'ØNØ':
                $this->direction = 'Øst-nordøst';
                $this->setAbbreviation('ØNØ');
                break;
            case 'ØSØ':
                $this->direction = 'Øst-sydøst';
                $this->setAbbreviation('ØSØ');
                break;
            case 'SSØ':
                $this->direction = 'Syd-sydøst';
                $this->setAbbreviation('SSØ');
                break;
            case 'SSV':
                $this->direction = 'Syd-sydvest';
                $this->setAbbreviation('SSV');
                break;
            case 'VNV':
                $this->direction = 'Vest-nordvest';
                $this->setAbbreviation('VNV');
                break;
            case 'VSV':
                $this->direction = 'Vest-sydvest';
                $this->setAbbreviation('VSV');
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
        $this->degrees = $degrees !== null ? (float) $degrees : 0.0;
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