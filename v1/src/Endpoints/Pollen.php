<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Endpoints;

use DateTime;
use Rugaard\DMI\Old\DTO\Pollen as PollenDTO;
use Tightenco\Collect\Support\Collection;

/**
 * Class Pollen.
 *
 * @package Rugaard\DMI\Old\Endpoints
 */
class Pollen extends AbstractEndpoint
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

        // Decode nested XML.
        $data['products']['text'] = simplexml_load_string($data['products']['text']);

        $this->setData(Collection::make([
            'regions' => Collection::make([
                'east' => new PollenDTO((array) $data['products']['text']->xpath('region')[0]),
                'west' => new PollenDTO((array) $data['products']['text']->xpath('region')[1])
            ]),
            'meta' => Collection::make([
                'timestamp' => DateTime::createFromFormat('U e', floor($data['products']['timestamp'] / 1000) . ' Europe/Copenhagen'),
                'comment' => trim((string) $data['products']['text']->xpath('comment')[0]),
                'info' => trim((string) $data['products']['text']->xpath('info')[0]),
                'copyright' => trim((string) $data['products']['text']->xpath('copyright')[0]),
            ]),
        ]));
    }
}
