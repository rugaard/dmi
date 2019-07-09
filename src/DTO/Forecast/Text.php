<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Forecast;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\DTO\AbstractDTO;

/**
 * Class Text.
 *
 * @package Rugaard\DMI\DTO\Forecast
 */
class Text extends AbstractDTO
{
    /**
     * Title of forecast.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Text forecast.
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
     * Validity of forecast.
     *
     * @var string|null
     */
    protected $validity;

    /**
     * Issued timestamp.
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
    public function parse(array $data): void
    {
        $this->setTitle($data['title'])
             ->setText($data['text'])
             ->setDate($data['date'])
             ->setValidity($data['validity'])
             ->setIssuedAt($data['timestamp']);
    }

    /**
     * Set title.
     *
     * @param  string $title
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle() :? string
    {
        return $this->title;
    }

    /**
     * Set text forecast.
     *
     * @param  string $text
     * @return $this
     */
    public function setText(string $text) : self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text forecast.
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
     * Set validity of forecast.
     *
     * @param  string $validity
     * @return $this
     */
    public function setValidity(string $validity) : self
    {
        $this->validity = $validity;
        return $this;
    }

    /**
     * Get validity of forecast.
     *
     * @return string|null
     */
    public function getValidity() :? string
    {
        return $this->validity;
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