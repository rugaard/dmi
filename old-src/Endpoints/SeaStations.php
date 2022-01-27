<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Endpoints;

use Rugaard\OldDMI\DTO\SeaStation;
use Tightenco\Collect\Support\Collection;

/**
 * Class SeaStations
 *
 * @package Rugaard\OldDMI\Endpoints
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
