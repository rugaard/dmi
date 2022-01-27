<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Endpoints;

use DateTime;
use DateTimeZone;
use Rugaard\OldDMI\DTO\Warning;
use Tightenco\Collect\Support\Collection;

/**
 * Class Warnings
 *
 * @package Rugaard\OldDMI\Endpoints
 */
class Warnings extends AbstractEndpoint
{
    /**
     * Title of warning.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Affected area.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $area;

    /**
     * Issued date.
     *
     * @var \DateTime|null
     */
    protected $issued;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        if (empty($data)) {
            return;
        }

        $this->setTitle($data['title'])
             ->setArea($data['totalArea'])
             ->setIssued($data['overviewIssued']);

        // Collection of warnings.
        $warnings = Collection::make();

        foreach ($data['warnings'] as $warning) {
            $warnings->push(new Warning($warning));
        }

        // Set data with collection of warnings.
        $this->setData($warnings);
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
     * Set affected areas.
     *
     * @param  string $areas
     * @return $this
     */
    public function setArea(string $areas) : self
    {
        $this->area = $areas;
        return $this;
    }

    /**
     * Get affected areas.
     *
     * @return string|null
     */
    public function getArea() :? string
    {
        return $this->area;
    }

    /**
     * Set issued date.
     *
     * @param  int $timestamp
     * @return $this
     */
    public function setIssued(int $timestamp) : self
    {
        $this->issued = DateTime::createFromFormat('U e', ($timestamp / 1000) . ' Europe/Copenhagen');
        return $this;
    }

    /**
     * Get issued date.
     *
     * @return \DateTime|null
     */
    public function getIssued() :? DateTime
    {
        return $this->issued;
    }
}
