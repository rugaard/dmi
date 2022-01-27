<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Percentage.
 *
 * @package Rugaard\DMI\Units
 */
class Percentage extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Percent';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Percent';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = '%';
}
