<?php
declare(strict_types=1);

namespace Rugaard\DMI\Support\Traits;

/**
 * Trait Icon
 *
 * @package Rugaard\DMI\Support\Traits
 */
trait Icon
{
    /**
     * Icon name.
     *
     * @var string|null
     */
    protected $icon;

    /**
     * Set icon name by symbol ID.
     *
     * @param  int|null $icon
     * @return $this
     */
    public function setIconById(?int $icon) : self
    {
        switch ($icon) {
            case 1:
                $this->setIcon('clear');
                break;
            case 2:
                $this->setIcon('partly-cloudy');
                break;
            case 3:
                $this->setIcon('cloudy');
                break;
            case 38:
                $this->setIcon('blowing-snow');
                break;
            case 45:
                $this->setIcon('foggy');
                break;
            case 60:
                $this->setIcon('light-rain');
                break;
            case 63:
                $this->setIcon('heavy-rain');
                break;
            case 68:
                $this->setIcon('light-sleet');
                break;
            case 69:
                $this->setIcon('heavy-sleet');
                break;
            case 70:
                $this->setIcon('light-snow');
                break;
            case 73:
                $this->setIcon('heavy-snow');
                break;
            case 80:
                $this->setIcon('clear-light-rain');
                break;
            case 81:
                $this->setIcon('clear-heavy-rain');
                break;
            case 83:
                $this->setIcon('clear-light-sleet');
                break;
            case 84:
                $this->setIcon('clear-heavy-sleet');
                break;
            case 85:
                $this->setIcon('clear-light-snow');
                break;
            case 86:
                $this->setIcon('clear-heavy-snow');
                break;
            case 95:
                $this->setIcon('thunderstorm');
                break;
            case 101:
                $this->setIcon('clear-night');
                break;
            case 102:
                $this->setIcon('partly-cloudy-night');
                break;
            case 103:
                $this->setIcon('cloudy-night');
                break;
            case 138:
                $this->setIcon('blowing-snow-night');
                break;
            case 145:
                $this->setIcon('foggy-night');
                break;
            case 160:
                $this->setIcon('light-rain-night');
                break;
            case 163:
                $this->setIcon('heavy-rain-night');
                break;
            case 168:
                $this->setIcon('light-sleet-night');
                break;
            case 169:
                $this->setIcon('heavy-sleet-night');
                break;
            case 170:
                $this->setIcon('light-snow-night');
                break;
            case 173:
                $this->setIcon('heavy-snow-night');
                break;
            case 180:
                $this->setIcon('clear-light-rain-night');
                break;
            case 181:
                $this->setIcon('clear-heavy-rain-night');
                break;
            case 183:
                $this->setIcon('clear-light-sleet-night');
                break;
            case 184:
                $this->setIcon('clear-heavy-sleet-night');
                break;
            case 185:
                $this->setIcon('clear-light-snow-night');
                break;
            case 186:
                $this->setIcon('clear-heavy-snow-night');
                break;
            case 195:
                $this->setIcon('thunderstorm-night');
        }
        return $this;
    }

    /**
     * Set icon name.
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon(string $icon) : self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get icon name.
     *
     * @return string|null
     */
    public function getIcon() :? string
    {
        return $this->icon;
    }
}