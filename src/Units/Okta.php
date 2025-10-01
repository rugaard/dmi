<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Okta.
 */
class Okta extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Okta';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Oktas';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'Oktas';

    /**
     * Prefer abbreviation of unit.
     *
     * @var bool
     */
    protected bool $preferAbbreviation = false;
}
