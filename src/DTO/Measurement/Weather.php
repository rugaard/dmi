<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Length\Meter;

/**
 * Class Weather.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Weather extends Measurement
{
    use HasLocation, HasParameterId, HasObservedTimestamp, HasStationId;

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        parent::parse($data);

        $this->setType('current')
             ->setParameterId($data['properties']['parameterId'] ?? null)
             ->setValue($data['properties']['value'])
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        $this->setDescription(match ((int) $data['properties']['value']) {
            // [0-19] OR [100-119]
            // No precipitation, fog, ice fog (except for 111 and 112), dust storm, sandstorm, drifting or blowing snow
            // at the station at the time of observation or, except for 109 and 117, during the preceding hour.
            0, 100 => 'Cloud development not observed or not observable',
            1, 101 => 'Clouds generally dissolving or becoming less developed',
            2, 102 => 'State of sky on the whole unchanged',
            3, 103 => 'Clouds generally forming or developing',
            4, 104 => 'Visibility reduced by smoke, e.g. veldt or forest fires, industrial smoke or volcanic ashes',
            5, 105 => 'Haze',
            6, 106 => 'Widespread dust in suspension in the air, not raised by wind at or near the station at the time of observation',
            7, 107 => 'Dust or sand raised by wind at or near the station at the time of observation, but no well developed dust whirl(s) or sand whirl(s), and no dust storm or sandstorm seen',
            8, 108 => 'Well developed dust whirl(s) or sand whirl(s) seen at or near the station during the preceding hour or at the time ot observation, but no dust storm or sandstorm',
            9, 109 => 'Dust storm or sandstorm within sight at the time of observation, or at the station during the preceding hour',
            10, 110 => 'Mist',
            11, 111 => 'Patches of shallow fog or ice fog at the station, whether on land or sea, not deeper than about 2 metres on land or 10 metres at sea',
            12, 112 => 'More or less continuous shallow fog or ice fog at the station, whether on land or sea, not deeper than about 2 metres on land or 10 metres at sea',
            13, 113 => 'Lightning visible, no thunder heard',
            14, 114 => 'Precipitation within sight, not reaching the ground or the surface of the sea',
            15, 115 => 'Precipitation within sight, reaching the ground or the surface of the sea, but distant, i.e. estimated to be more than 5 km from the station',
            16, 116 => 'Precipitation within sight, reaching the ground or the surface of the sea, near to, but not at the station',
            17, 117 => 'Thunderstorm, but no precipitation at the time of observation',
            18, 118 => 'Squalls at or within sight of the station during the preceding hour or at the time of observation',
            19, 119 => 'Funnel cloud(s) (tornado cloud or water-spout) at or within sight of the station during the preceding hour or at the time of observation',
            // [20-29] OR [120-129]
            // Precipitation, fog, ice fog og thunderstorm at the station during the preceding hour but not at the time of observation.
            20, 120 => 'Drizzle (not freezing) or snow grains not falling as shower(s)',
            21, 121 => 'Rain (not freezing) not falling as shower(s)',
            22, 122 => 'Snow not falling as shower(s)',
            23, 123 => 'Rain and snow or ice pellets not falling as shower(s)',
            24, 124 => 'Freezing drizzle or freezing rain not falling as shower(s)',
            25, 125 => 'Shower(s) of rain',
            26, 126 => 'Shower(s) of snow, or of rain and snow',
            27, 127 => 'Shower(s) of hail, or of rain and hail',
            28, 128 => 'Fog or ice fog',
            29, 129 => 'Thunderstorm (with or without precipitation)',
            // [30-39] OR [130-139]
            // Dust storm, sandstorm, drifting or blowing snow
            30, 130 => 'Slight or moderate dust storm or sandstorm has decreased during the preceding hour',
            31, 131 => 'Slight or moderate dust storm or sandstorm with no appreciable change during the preceding hour',
            32, 132 => 'Slight or moderate dust storm or sandstorm has begun or has increased during the preceding hour',
            33, 133 => 'Severe dust storm or sandstorm has decreased during the preceding hour',
            34, 134 => 'Severe dust storm or sandstorm with no appreciable change during the preceding hour',
            35, 135 => 'Severe dust storm or sandstorm has begun or has increased during the preceding hour',
            36, 136 => 'Slight or moderate blowing snow (generally low, below eye level)',
            37, 137 => 'Heavy drifting snow (generally low, below eye level)',
            38, 138 => 'Slight or moderate blowing snow (generally high, above eye level)',
            39, 139 => 'Heavy drifting snow (generally high, above eye level)',
            // [40-49] OR [140-149]
            // Fog or ice fog at the time of observations
            40, 140 => 'Fog or ice fog at a distance at the time of observation, but not at the station during the preceding hour, the fog or ice fog extending to a level above that of the observer',
            41, 141 => 'Fog or ice fog in patches',
            42, 142 => 'Fog or ice fog (sky visible) has become thinner during the preceding hour',
            43, 143 => 'Fog or ice fog (sky invisible) has become thinner during the preceding hour',
            44, 144 => 'Fog or ice fog (sky visible) with no appreciable change during the preceding hour',
            45, 145 => 'Fog or ice fog (sky invisible) with no appreciable change during the preceding hour',
            46, 146 => 'Fog or ice fog (sky visible) has begun or has become thicker during the preceding hour',
            47, 147 => 'Fog or ice fog (sky invisible) has begun or has become thicker during the preceding hour',
            48, 148 => 'Fog, depositing rime (sky visible)',
            49, 149 => 'Fog, depositing rime (sky invisible)',
            // [50-59] OR [150-159]
            // Drizzle
            50, 150 => 'Drizzle, not freezing, intermittent, slight at time of observation',
            51, 151 => 'Drizzle, not freezing, continuous, slight at time of observation',
            52, 152 => 'Drizzle, not freezing, intermittent, moderate at time of observation',
            53, 153 => 'Drizzle, not freezing, continuous, moderate at time of observation',
            54, 154 => 'Drizzle, not freezing, intermittent, heavy (dense) at time of observation',
            55, 155 => 'Drizzle, not freezing, continuous, heavy (dense) at time of observation',
            56, 156 => 'Drizzle, freezing, slight',
            57, 157 => 'Drizzle, freezing, moderate or heavy (dense)',
            58, 158 => 'Drizzle and rain, slight',
            59, 159 => 'Drizzle and rain, moderate or heavy',
            // [60-69] OR [160-169]
            // Rain
            60, 160 => 'Rain, not freezing, intermittent, slight at time of observation',
            61, 161 => 'Rain, not freezing, continuous, slight at time of observation',
            62, 162 => 'Rain, not freezing, intermittent, moderate at time of observation',
            63, 163 => 'Rain, not freezing, continuous, moderate at time of observation',
            64, 164 => 'Rain, not freezing, intermittent, heavy at time of observation',
            65, 165 => 'Rain, not freezing, continuous, heavy at time of observation',
            66, 166 => 'Rain, freezing, slight',
            67, 167 => 'Rain, freezing, moderate or heavy (dense)',
            68, 168 => 'Rain or drizzle and snow, slight',
            69, 169 => 'Rain or drizzle and snow, moderate or heavy',
            // [70-79] OR [170-179]
            // Solid precipitation not in showers
            70, 170 => 'Intermittent fall of snowflakes, slight at time of observation',
            71, 171 => 'Continuous fall of snowflakes, slight at time of observation',
            72, 172 => 'Intermittent fall of snowflakes, moderate at time of observation',
            73, 173 => 'Continuous fall of snowflakes, moderate at time of observation',
            74, 174 => 'Intermittent fall of snowflakes, heavy at time of observation',
            75, 175 => 'Continuous fall of snowflakes, heavy at time of observation',
            76, 176 => 'Diamond dust (with or without fog)',
            77, 177 => 'Snow grains (with or without fog)',
            78, 178 => 'Isolated star-like snow crystals (with or without fog)',
            79, 179 => 'Ice pellets',
            // [80-99] OR [180-199]
            // Showery precipitation, or precipitation with current or recent thunder
            80, 180 => 'Rain shower(s), slight',
            81, 181 => 'Rain shower(s), moderate or heavy',
            82, 182 => 'Rain shower(s), violent',
            83, 183 => 'Shower(s) of rain and snow mixed, slight',
            84, 184 => 'Shower(s) of rain and snow mixed, moderate or heavy',
            85, 185 => 'Snow shower(s), slight',
            86, 186 => 'Snow shower(s), moderate or heavy',
            87, 187 => 'Shower(s) of snow pellets or small hail, with or without rain or rain and snow mixed, slight',
            88, 188 => 'Shower(s) of snow pellets or small hail, with or without rain or rain and snow mixed, moderate or heavy',
            89, 189 => 'Shower(s) of hail, with or without rain or rain and snow mixed, not associated with thunder, slight',
            90, 190 => 'Shower(s) of hail, with or without rain or rain and snow mixed, not associated with thunder, moderate or heavy',
            91, 191 => 'Slight rain at time of observation, thunderstorm during the preceding hour but not at time of observation',
            92, 192 => 'Moderate or heavy rain at time of observation, thunderstorm during the preceding hour but not at time of observation',
            93, 193 => 'Slight snow, or rain and snow mixed or hail at time of observation, thunderstorm during the preceding hour but not at time of observation',
            94, 194 => 'Moderate or heavy snow, or rain and snow mixed or hail at time of observation, thunderstorm during the preceding hour but not at time of observation',
            95, 195 => 'Thunderstorm, slight or moderate, without hail but with rain and/or snow at time of observation',
            96, 196 => 'Thunderstorm, slight or moderate, with hail at time of observation',
            97, 197 => 'Thunderstorm, heavy, without hail but with rain and/or snow at time of observation',
            98, 198 => 'Thunderstorm combined with dust storm or sandstorm at time of observation',
            99, 199 => 'Thunderstorm, heavy, with hail at time of observation',

            // Fallback, to avoid parsing errors.
            default => 'Unknown or unsupported weather condition'
        });
    }
}
