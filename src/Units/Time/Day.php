<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Day.
 *
 * @package Rugaard\DMI\Unit\Time
 */
class Day extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Day';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Days';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'd';
}
