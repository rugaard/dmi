<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Hour.
 */
class Hour extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Hour';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Hours';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'hrs';
}
