<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Speed;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class MetresPerSecond.
 *
 * @package Rugaard\DMI\Unit\Speed
 */
class MetersPerSecond extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Meter per second';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Meters per second';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'm/s';
}
