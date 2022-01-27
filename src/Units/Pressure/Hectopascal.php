<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Pressure;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Hectopascal.
 *
 * @package Rugaard\DMI\Unit\Pressure
 */
class Hectopascal extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Hectopascal';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Hectopascals';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'hPa';
}
