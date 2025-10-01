<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

/**
 * Class Unit.
 */
abstract class Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name;

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural;

    /**
     * Abbreviation of unit.
     *
     * @var string
     */
    public string $abbreviation;

    /**
     * Prefer abbreviation of unit.
     *
     * @var bool
     */
    protected bool $preferAbbreviation = true;

    /**
     * Stringify unit with name or abbreviation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->preferAbbreviation ? $this->abbreviation : $this->name;
    }
}
