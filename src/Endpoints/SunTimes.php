<?php
declare(strict_types=1);

namespace Rugaard\DMI\Endpoints;

use Rugaard\DMI\DTO\SunTime;
use Tightenco\Collect\Support\Collection;

/**
 * Class SunTimes
 *
 * @package Rugaard\DMI\Endpoints
 */
class SunTimes extends AbstractEndpoint
{
    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        if (empty($data)) {
            return;
        }

        // Container.
        $sunTimes = Collection::make();

        foreach ($data as $sunTime) {
            $sunTimes->push(
                new SunTime($sunTime)
            );
        }

        $this->setData($sunTimes);
    }
}