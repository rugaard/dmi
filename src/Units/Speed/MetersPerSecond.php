<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Speed;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class MetresPerSecond.
 */
class MetersPerSecond extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Meter per second';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Meters per second';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'm/s';
}
