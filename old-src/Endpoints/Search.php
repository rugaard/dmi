<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Endpoints;

use Tightenco\Collect\Support\Collection;
use Rugaard\OldDMI\DTO\Search as SearchDTO;

/**
 * Class Search
 *
 * @package Rugaard\OldDMI\Endpoints
 */
class Search extends AbstractEndpoint
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
        $result = Collection::make();

        foreach ($data as $item) {
            $result->push(
                new SearchDTO($item)
            );
        }

        $this->setData($result);
    }
}
