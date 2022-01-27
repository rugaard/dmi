<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Endpoints;

use DateTime;
use DateTimeZone;
use Tightenco\Collect\Support\Collection;

/**
 * Class UV
 *
 * @package Rugaard\DMI\Old\Endpoints
 */
class UV extends AbstractEndpoint
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

        $this->setData(Collection::make([
            'date' => DateTime::createFromFormat('U', (string) floor($data['date'] / 1000))->setTimezone(new DateTimeZone('Europe/Copenhagen')),
            'today' => Collection::make([
                'value' => $data['today'],
                'level' => $this->getLevelByValue($data['today'])
            ]),
            'peak' => Collection::make([
                'value' => $data['later'],
                'level' => $this->getLevelByValue($data['later'])
            ]),
            'tomorrow' => Collection::make([
                'value' => $data['tomorrow'],
                'level' => $this->getLevelByValue($data['tomorrow'])
            ]),
        ]));
    }

    /**
     * Get UV level by UV value.
     *
     * @param  float|null $value
     * @return string
     */
    private function getLevelByValue(?float $value) : string
    {
        if ($value > 10) {
            return 'Extreme';
        } elseif ($value > 8) {
            return 'Very high';
        } elseif ($value > 6) {
            return 'High';
        } elseif ($value > 3) {
            return 'Moderate';
        } else {
            return 'Low';
        }
    }
}
