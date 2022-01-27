<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Endpoints;

use DateTime;
use DateTimeZone;
use Tightenco\Collect\Support\Collection;

/**
 * Class Forecast
 *
 * @package Rugaard\DMI\Old\Endpoints
 */
class Forecast extends AbstractEndpoint
{
    /**
     * Title of forecast.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Text of forecast.
     *
     * @var string|null
     */
    protected $text;

    /**
     * Date of forecast.
     *
     * @var string|null
     */
    protected $date;

    /**
     * Uncertainty of forecast.
     *
     * @var string|null
     */
    protected $uncertainty;

    /**
     * Issued at timestamp.
     *
     * @var \DateTime|null
     */
    protected $issuedAt;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setTitle($data['title'])
            ->setText($data['text'])
            ->setDate($data['date'])
            ->setUncertainty($data['uncertainty'])
            ->setIssuedAt($data['timestamp']);

        // Collection of daily forecasts.
        $days = Collection::make();

        // Parse each available daily forecast.
        foreach ($data['days'] as $dailyForecast) {
            // Convert to array
            $dailyForecast = (array) $dailyForecast;

            // Get name of day.
            $day = (string) $dailyForecast['text'];

            // If day is empty,
            // then we'll skip it and move on.
            if (empty($day)) {
                continue;
            }

            // Add daily forecast to Collection.
            $days->push(Collection::make([
                'title' => str_replace(':', '', $day),
                'text' => (string) array_pop($dailyForecast)->text
            ]));
        }

        // Set daily forecast as data.
        $this->setData($days);
    }

    /**
     * Set title of forecast.
     *
     * @param  string $title
     * @return \Rugaard\DMI\Old\Endpoints\Forecast
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title of forecast.
     *
     * @return string|null
     */
    public function getTitle() :? string
    {
        return $this->title;
    }

    /**
     * Set text of forecast.
     *
     * @param  string $text
     * @return \Rugaard\DMI\Old\Endpoints\Forecast
     */
    public function setText(string $text) : self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text of forecast.
     *
     * @return string|null
     */
    public function getText() :? string
    {
        return $this->text;
    }

    /**
     * Set date of forecast.
     *
     * @param  string $date
     * @return $this
     */
    public function setDate(string $date) : self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date of forecast.
     *
     * @return string|null
     */
    public function getDate() :? string
    {
        return $this->date;
    }

    /**
     * Set uncertainty of forecast.
     *
     * @param  string $uncertainty
     * @return $this
     */
    public function setUncertainty(string $uncertainty) : self
    {
        $this->uncertainty = $uncertainty;
        return $this;
    }

    /**
     * Get uncertainty of forecast.
     *
     * @return string|null
     */
    public function getUncertainty() :? string
    {
        return $this->uncertainty;
    }

    /**
     * Set issued at timestamp.
     *
     * @param int                $timestamp
     * @param \DateTimeZone|null $timezone
     * @return $this
     */
    public function setIssuedAt(int $timestamp, ?DateTimeZone $timezone = null) : self
    {
        // Fallback timezone is "Europe/Copenhagen".
        $timezone = ($timezone instanceof DateTimeZone ) ? $timezone : new DateTimeZone($timezone ?? 'Europe/Copenhagen');

        $this->issuedAt = DateTime::createFromFormat('U', (string) floor($timestamp / 1000))->setTimezone($timezone);
        return $this;
    }

    /**
     * Get issued at timestamp.
     *
     * @return \DateTime|null
     */
    public function getIssuedAt() :? DateTime
    {
        return $this->issuedAt;
    }
}
