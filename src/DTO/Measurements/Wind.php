<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements;

use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Measurements\Wind\Direction;
use Rugaard\DMI\DTO\Measurements\Wind\Gust;
use Rugaard\DMI\DTO\Measurements\Wind\Speed;

/**
 * Class Wind.
 *
 * @package Rugaard\DMI\DTO\Measurements
 */
class Wind extends AbstractDTO
{
    /**
     * Wind speed.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Wind\Speed|null
     */
    protected $speed;

    /**
     * Wind direction.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Wind\Direction|null
     */
    protected $direction;

    /**
     * Wind gust.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Wind\Gust|null
     */
    protected $gust;

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->setSpeed(new Speed($data))
             ->setDirection(new Direction($data))
             ->setGust(new Gust($data));
    }

    /**
     * Set wind speed.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Wind\Speed $speed
     * @return $this
     */
    public function setSpeed(Speed $speed) : self
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * Get wind speed.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Wind\Speed|null
     */
    public function getSpeed() :? Speed
    {
        return $this->speed;
    }

    /**
     * Set wind direction.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Wind\Direction $direction
     * @return $this
     */
    public function setDirection(Direction $direction) : self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Get wind direction.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Wind\Direction|null
     */
    public function getDirection() :? Direction
    {
        return $this->direction;
    }

    /**
     * Set wind gust.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Wind\Gust $gust
     * @return $this
     */
    public function setGust(Gust $gust) : self
    {
        $this->gust = $gust;
        return $this;
    }

    /**
     * Get wind gust.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Wind\Gust|null
     */
    public function getGust() :? Gust
    {
        return $this->gust;
    }

    /**
     * __toString().
     *
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->getSpeed();
    }
}