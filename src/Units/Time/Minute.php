<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Minute.
 */
class Minute extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Minute';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Minutes';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'min';
}
