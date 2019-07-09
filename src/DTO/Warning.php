<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use DateTime;
use DateTimeZone;

/**
 * Class Warning
 *
 * @package Rugaard\DMI\DTO
 */
class Warning extends AbstractDTO
{
    /**
     * Title of warning.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Warning description.
     *
     * @var string|null
     */
    protected $description;

    /**
     * Additional note about warning.
     *
     * @var string|null
     */
    protected $note;

    /**
     * Affected area.
     *
     * @var string|null
     */
    protected $area;

    /**
     * Type of warning.
     *
     * @var string|null
     */
    protected $type;

    /**
     * Severity of warning.
     *
     * @var string|null
     */
    protected $severity;

    /**
     * Issued date.
     *
     * @var \DateTime|null
     */
    protected $issuedAt;

    /**
     * "Valid from" date.
     *
     * @var \DateTime|null
     */
    protected $validFrom;

    /**
     * "Valid to" date.
     *
     * @var \DateTime|null
     */
    protected $validTo;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setTitle($data['warningTitle'] ?? $data['warningText'] ?? null)
             ->setDescription($data['warningText'] ?? $data['warningTitle'] ?? null)
             ->setNote($data['additionalText'] ?? null)
             ->setArea($data['area'])
             ->setType($data['warningCause'])
             ->setSeverity((int) $data['warningType'])
             ->setIssuedAt($data['issuedAt'])
             ->setValidFrom($data['validFrom'])
             ->setValidTo($data['validTo']);
    }

    /**
     * Set title.
     *
     * @param  string|null $title
     * @return $this
     */
    public function setTitle(?string $title) : self
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
     * Set warning description.
     *
     * @param  string|null $description
     * @return $this
     */
    public function setDescription(?string $description) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get warning description.
     *
     * @return string|null
     */
    public function getDescription() :? string
    {
        return $this->description;
    }

    /**
     * Set additional note about warning.
     *
     * @param  string|null $note
     * @return $this
     */
    public function setNote(?string $note) : self
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Get additional note about warning.
     *
     * @return string|null
     */
    public function getNote() :? string
    {
        return $this->note;
    }

    /**
     * Set affected area.
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
     * Get affected area.
     *
     * @return string|null
     */
    public function getArea() :? string
    {
        return $this->area;
    }

    /**
     * Set type of warning.
     *
     * @param  string $type
     * @return \Rugaard\DMI\DTO\Warning
     */
    public function setType(string $type) : self
    {
        switch ($type) {
            case 'regn':
                $this->type = 'heavy-rain';
                break;
            case 'konvektion':
                $this->type = 'thunderstorm-cloudburst';
                break;
            case 'sne':
                $this->type = 'heavy-snow';
                break;
            case 'isslag':
                $this->type = 'black-ice';
                break;
            case 'tage':
                $this->type = 'mist-fog';
                break;
            case 'temperatur':
                $this->type = 'heat-wave';
                break;
            case 'vind':
                $this->type = 'heavy-wind';
                break;
            case 'forvand':
                $this->type = 'flooding';
                break;
        }
        return $this;
    }

    /**
     * Get type of warning.
     *
     * @return string|null
     */
    public function getType() :? string
    {
        return $this->type;
    }

    /**
     * Set severity of warning.
     *
     * @param  int $severity
     * @return \Rugaard\DMI\DTO\Warning
     */
    public function setSeverity(int $severity) : self
    {
        switch ($severity) {
            case 1:
                $this->severity = 'low';
                break;
            case 2:
                $this->severity = 'moderate';
                break;
            case 3:
                $this->severity = 'severe';
                break;
            case 4:
                $this->severity = 'dangerous';
                break;
        }
        return $this;
    }

    /**
     * Get severity of warning.
     *
     * @return string|null
     */
    public function getSeverity() :? string
    {
        return $this->severity;
    }

    /**
     * Set issued date.
     *
     * @param  int $timestamp
     * @return $this
     */
    public function setIssuedAt(int $timestamp) : self
    {
        $this->issuedAt = DateTime::createFromFormat('U', (string) ($timestamp / 1000))->setTimezone(new DateTimeZone(' Europe/Copenhagen'));
        return $this;
    }

    /**
     * Get issued date.
     *
     * @return \DateTime|null
     */
    public function getIssuedAt() :? DateTime
    {
        return $this->issuedAt;
    }

    /**
     * Set "valid from" date.
     *
     * @param  int $timestamp
     * @return $this
     */
    public function setValidFrom(int $timestamp) : self
    {
        $this->validFrom = DateTime::createFromFormat('U', (string) ($timestamp / 1000))->setTimezone(new DateTimeZone(' Europe/Copenhagen'));
        return $this;
    }

    /**
     * Get "valid from" date.
     *
     * @return \DateTime|null
     */
    public function getValidFrom() :? DateTime
    {
        return $this->validFrom;
    }

    /**
     * Set "valid to" date.
     *
     * @param  int $timestamp
     * @return $this
     */
    public function setValidTo(int $timestamp) : self
    {
        $this->validTo = DateTime::createFromFormat('U', (string) ($timestamp / 1000))->setTimezone(new DateTimeZone(' Europe/Copenhagen'));
        return $this;
    }

    /**
     * Get "valid to" date.
     *
     * @return \DateTime|null
     */
    public function getValidTo() :? DateTime
    {
        return $this->validTo;
    }
}