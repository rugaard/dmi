<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Bearing.
 *
 * @package Rugaard\DMI\Units
 */
class Bearing extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Degree';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Degrees';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = '°';
}
