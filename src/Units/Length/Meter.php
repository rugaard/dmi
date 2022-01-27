<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Meter.
 *
 * @package Rugaard\DMI\Unit\Length
 */
class Meter extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Meter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Meters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'm';
}
