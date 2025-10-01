<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Quarter.
 */
class Quarter extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Quarter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Quarters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'Quarters';

    /**
     * Prefer abbreviation of unit.
     *
     * @var bool
     */
    protected bool $preferAbbreviation = false;
}
