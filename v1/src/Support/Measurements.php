<?php
declare(strict_types=1);

use Tightenco\Collect\Support\Collection;

if (!function_exists('getMeasurementParameters')) {
    /**
     * Get measurement parameters.
     *
     * @return \Tightenco\Collect\Support\Collection
     */
    function getMeasurementParameters() : Collection
    {
        return Collection::make([
            'temperature' => Collection::make([
                'id' => 101,
                'name' => 'Middeltemperatur',
                'title' => 'Middeltemperatur',
            ]),
            'temperature-max' => Collection::make([
                'id' => 112,
                'name' => 'Maksimumtemperatur',
                'title' => 'Maksimumtemperatur',
            ]),
            'temperature-min' => Collection::make([
                'id' => 122,
                'name' => 'Minimumtemperatur',
                'title' => 'Minimumtemperatur',
            ]),
            'humidity' => Collection::make([
                'id' => 201,
                'name' => 'Luftfugtighed',
                'title' => 'Middel relativ luftfugtighed',
            ]),
            'pressure' => Collection::make([
                'id' => 401,
                'name' => 'Lufttryk',
                'title' => 'Lufttryk',
            ]),
            'wind' => Collection::make([
                'id' => 301,
                'name' => 'Middelvind',
                'title' => 'Middelvindhastighed',
            ]),
            'wind-max' => Collection::make([
                'id' => 302,
                'name' => 'Højeste middelvind',
                'title' => 'Højeste middelvind',
            ]),
            'wind-gust' => Collection::make([
                'id' => 305,
                'name' => 'Vindstød',
                'title' => 'Højeste vindstød',
            ]),
            'wind-direction' => Collection::make([
                'id' => 371,
                'name' => 'Vindretning',
                'title' => 'Middel vindretning',
            ]),
            'precipitation' => Collection::make([
                'id' => 601,
                'name' => 'Nedbør',
                'title' => 'Summeret nedbør',
            ]),
            'precipitation-corrected' => Collection::make([
                'id' => 621,
                'name' => 'Nedbør korrigeret',
                'title' => 'Korrigeret summeret nedbør',
            ]),
            'precipitation-intensity' => Collection::make([
                'id' => 633,
                'name' => 'Nedbørintensitet',
                'title' => 'Højeste nedbørsintensitet',
            ]),
            'sun' => Collection::make([
                'id' => 504,
                'name' => 'Sol',
                'title' => 'Summeret solskin',
            ]),
            'drought' => Collection::make([
                'id' => 212,
                'name' => 'Tørkeindeks',
                'title' => 'Tørkeindeks',
            ]),
            'lightning' => Collection::make([
                'id' => 680,
                'name' => 'Lyn',
                'title' => 'Lynnedslag',
            ]),
            'snow' => Collection::make([
                'id' => 906,
                'name' => 'Snedybde',
                'title' => 'Snedybde',
            ]),
        ]);
    }
}

if (!function_exists('getMeasurementParameterByKey')) {
    /**
     * Get measurement parameter by key.
     *
     * @param  string $key
     * @return \Tightenco\Collect\Support\Collection|null
     */
    function getMeasurementParameterByKey(string $key) :? Collection
    {
        return getMeasurementParameters()->get($key);
    }
}