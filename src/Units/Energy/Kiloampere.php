<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Kiloampere.
 */
class Kiloampere extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Kiloampere';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Kiloamperes';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'kA';
}
