<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Endpoints;

use Rugaard\DMI\Old\DTO\SeaStation;
use Tightenco\Collect\Support\Collection;

/**
 * Class SeaStations
 *
 * @package Rugaard\DMI\Old\Endpoints
 */
class SeaStations extends AbstractEndpoint
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
        $seaStations = Collection::make();

        foreach ($data as $seaStation) {
            $seaStations->push(
                new SeaStation($seaStation)
            );
        }

        $this->setData($seaStations);
    }
}
