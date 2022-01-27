<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Temperature;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Celsius.
 *
 * @package Rugaard\DMI\Unit\Temperatures
 */
class Celsius extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Celsius';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Celsius';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = '°C';
}
