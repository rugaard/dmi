<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

/**
 * Class AbstractUnit.
 *
 * @package Rugaard\DMI\Abstracts
 */
abstract class AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular;

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural;

    /**
     * Abbreviation of unit.
     *
     * @var string
     */
    protected string $abbreviation;

    /**
     * Prefer abbreviation when stringifying unit.
     *
     * @var bool
     */
    protected bool $preferAbbreviation = true;

    /**
     * Get unit name in singular form.
     *
     * @return string
     */
    public function getNameAsSingular(): string
    {
        return $this->singular;
    }

    /**
     * Get unit name in plural form.
     *
     * @return string
     */
    public function getNameAsPlural(): string
    {
        return $this->plural;
    }

    /**
     * Get unit abbreviation.
     *
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * Use abbreviation when stringifying unit.
     *
     * @return bool
     */
    protected function useAbbreviation(): bool
    {
        return $this->preferAbbreviation && $this->abbreviation !== null;
    }

    /**
     * Return unit with value and abbreviation.
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->useAbbreviation()) {
            return $this->getAbbreviation();
        }

        return $this->getNameAsSingular();
    }
}
