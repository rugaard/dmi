<div align="center"><img src="https://rugaard.github.io/packages/dmi/logo.jpg"></div>

# 🇩🇰🌤️ Danish Meteorological Institute (DMI) API.

<a href="https://github.com/rugaard/dmi/releases"><img src="https://img.shields.io/github/release/rugaard/dmi.svg"></a>
<a href="https://travis-ci.org/rugaard/dmi"><img src="https://travis-ci.org/rugaard/dmi.svg?branch=master"></a>
<a href="https://codeclimate.com/github/rugaard/dmi"><img src="https://img.shields.io/codeclimate/coverage/rugaard/dmi.svg"></a>
<a href="https://codeclimate.com/github/rugaard/dmi"><img src="https://img.shields.io/codeclimate/maintainability/rugaard/dmi.svg"></a>
<a href="https://creativecommons.org/licenses/by-nc-nd/4.0/"><img src="https://img.shields.io/static/v1.svg?labelColor=5f5f5f&label=license&color=43897a&message=CC%20BY-NC-ND"></a>

The Danish Meteorological Institute (DMI) does unfortunately not offer an official API ([yet](#%EF%B8%8F-disclaimer)). 

This package is (in some form) a workaround for that. It collects all weather data (forecasts and archived) from the official DMI website and turns it into structured data objects.

_**Note: Since the data is being extracted from a the website, there is a risk of the package could stop working, if the website does any breaking changes.**_

_**Should this happen, please don't hesitate to [create an issue](https://github.com/rugaard/dmi/issues/new) and I will look into it as quickly as possible**_

## ⚠️ Disclaimer
As part of the danish governments desire to become one of the *digital frontrunners*, they have decided that the Danish Meteorological Institute (DMI) has to make all of their data available to the public.

The data will be released in multiple stages over the **next 3 years**, starting from **Q3 in 2019** until **Q4 in 2022**. Unfortunately there is not much information on how the data will be released.

Depending on how the data will be released, this package will be subject to changes in the future.

**Since the data is not officially released, this package is made available under a very strict license, which prohibits any use other than personal.**

When DMI releases the data publicly, the license will be changed to a more open source-friendly (MIT) version.

## 📖 Table of contents

* [Features](#-features)
* [Installation](#-installation)
    * [Laravel](#laravel)
* [Usage](#%EF%B8%8F-usage)
    * [DMI Client](#dmi-client)
    * [Methods](#methods)
        * [National forecast](#national-forecast)
        * [Extended national forecast](#extended-national-forecast) 
        * [Search locations](#search-locations)
        * [Location by ID](#location-by-id)
        * [Location by coordinate](#location-by-coordinate)
        * [Weather warnings](#weather-warnings)
        * [Sun times](#sun-times)
        * [UV index](#uv-index)
        * [Pollen](#pollen)
        * [Sea stations](#sea-stations)
        * [Sea station by ID](#sea-station-by-id)
        * [Archived weather data](#archived-weather-data)
* [Icons](#-icons)
    * [Day](#day-after-sunrise)
    * [Night](#night-after-sunset)
* [Municipalities](#-municipalities)
* [Frequently Asked Questions (FAQ)](#-frequently-asked-questions-faq)
    * [How do I find the ID of a pre-defined location?](#how-do-i-find-the-id-of-a-pre-defined-location)
    * [What is this `Tightenco\Collect\Support\Collection` class and how does it work?](#what-is-this-tightencocollectsupportcollection-class-and-how-does-it-work)
* [Roadmap](#-roadmap)
    * [Internal caching](#internal-caching)
* [License](#-license)

## 🚀 Features

| Name | Description | Supported |
| :--- | :--- | :---: |
| National forecasts | National descriptive forecasts (incl. 7 days forecast) | ✅ |
| Search | Search pre-defined locations | ✅ |
| Location | Weather data/forecast for a pre-defined location | ✅ |
| Location by coordinate | Weather data/forecast for a location based on coordinates _(latitude/longitude)_ | ✅ |
| Weather warnings | National weather warnings | ✅ |
| Sun times | Time of sunrise and sunset | ✅ |
| UV index | Current UV index | ✅ |
| Pollen | Current Pollen measurements | ✅ |
| Sea stations | All national sea stations and their observations and forecasts | ✅ |
| Sea station by ID | Observations and forecasts from a specific sea station | ✅ |
| Archive | Hourly, daily, monthly and yearly data from the DMI archive | ✅ |
| Satellite | Satellite imagery | ❌ |
| Maritime forecasts | Forecasts around the coasts of Denmark, Greenland &amp; Faroe Islands | ❌ |
| Ice charts | Ice charts along the coasts of Greenland | ❌ |

## 📦 Installation
You can install the package via [Composer](https://getcomposer.org/), by using the following command:
```shell
composer require rugaard/dmi
```

### Laravel
This package comes with a out-of-the-box Service Provider for the [Laravel](http://laravel.com) framework.
If you're using a newer version of Laravel (`>= 5.5`) then the service provider will loaded automatically.

Are you using an older version, then you need to manually add the service provider to the `config/app.php` file:
```php
'providers' => [
    Rugaard\DMI\Providers\Laravel\ServiceProvider::class,
]
```

## ⚙️ Usage

First thing you need to do, is to instantiate the `DMI` client

```php
# Instantiate the DMI client.
$dmi = new \Rugaard\DMI\Client;
```

Once you've done that, you're able to request one or more of the supported features:
```php
# National forecast.
$forecast = $dmi->forecast();

# Location by coordinate.
$location = $dmi->locationByCoordinate(55.67594, 12.56553);

# National warnings.
$warnings = $dmi->warnings();
```

### DMI client

The DMI client which handles all request DMI.

```php
new DMI(?int $defaultLocationId, ?Client $httpClient);
```

| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$defaultLocationId` | `int` | `null` | Set default location ID |
| `$httpClient` | `\GuzzleHttp\ClientInterface` | `null` | Replace the default underlying HTTP Client |

### Methods

#### National forecast

Get the latest national descriptive forecast.

```php
forecast();
```

#### Extended national forecast

Get the extended (_7-days_) national descriptive forecast.

```php
extendedForecast();
```

#### Search locations

Search locations by name.

```php
search(string $query, int $limit);
```

| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$query` | `string` | - | Search query |
| `$limit` | `int` | `20` | Max. number of locations to return. |

#### Location by ID

Get current weather condition and latest forecast for a pre-defined location.

_Note: `$includeRegional` is required to get `municipality` and `region` of location._

```php
location(?int $locationId, bool $includeRegional, bool $includeWarnings);
```

| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$locationId` | `int` | `null` | ID of location _(If `null`, it'll use the default location ID from the `DMI` client.)_ |
| `$includeRegional` | `bool` | `true` | Include regional data and forecast for location `*` |
| `$includeWarnings` | `bool` | `true` | Include weather warnings specific for location `*` |

_`*` Makes additional request to DMI._

#### Location by coordinate

Get current weather condition and latest forecast for a location specified by coordinates.

_Note: `$includeRegional` is required to get `municipality` and `region` of location._

```php
locationByCoordinate(float $latitude, float $longitude, bool $includeRegional, bool $includeWarnings);
```

| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$latitude` | `float` | - | Latitude part of coordinate |
| `$longitude` | `float` | - | Longitude part of coordinate |
| `$includeRegional` | `bool` | `true` | Include regional data and forecast for location `*` |
| `$includeWarnings` | `bool` | `true` | Include weather warnings specific for location `*` |

_`*` Makes additional request to DMI._

#### Weather warnings

Get national weather warnings.

```php
warnings();
```

#### Sun times

Get time of the sunrise and sunset, for the next 14 days, for a pre-defined location.

```php
sunTimes(?int $locationId);
```
| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$locationId` | `int` | `null` | ID of location _(If `null`, it'll use the default location ID from the `DMI` client.)_  |

#### UV index

Get the current UV index for a pre-defined location.

```php
uv(?int $locationId);
```
| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$locationId` | `int` | `null` | ID of location _(If `null`, it'll use the default location ID from the `DMI` client.)_  |

#### Pollen

Get the current national pollen measurements.

```php
pollen();
```

#### Sea stations

Get all sea stations belonging to DMI.

```php
seaStations(bool $withObservations, bool $withForecast);
```
| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$withObservations` | `bool` | `false` | Include observation data from each station `*` |
| `$withForecast` | `bool` | `false` | Include forecast data for each station `*` |

_`*` Makes additional request to DMI._

#### Sea station by ID

Get a specific sea stations.

```php
seaStation(int $stationId, bool $withObservations, bool $withForecast);
```
| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$stationId` | `int` | - | ID of sea station |
| `$withObservations` | `bool` | `false` | Include observation data from each station `*` |
| `$withForecast` | `bool` | `false` | Include forecast data for each station `*` |

_`*` Makes additional request to DMI._

#### Archived weather data

Get archived weather data.

```php
archive(string $measurement, string $frequency, $period, ?int $municipalityId, string $country);
```

| Parameter | Type | Default | Description |
| :--- | :--- | :---: | :--- |
| `$measurement` | `string` | - | `temperature`, `precipitation`, `wind`, `wind-direction`, `humidity`, `pressure`, `sun`, `drought`, `lightning` or `snow` |
| `$frequency` | `string` | - | `hourly`, `daily`, `monthly` or `yearly` |
| `$period` | `string` or `DateTime` | - | `hourly`/`daily` = `YYYY-mm-dd`, `monthly` = `YYYY-mm`<br>or `yearly` = `YYYY` |
| `$municipalityId` | `int` | `null` | Limit archived data to a specific municipality. [See the full list of available municipality IDs](#-municipalities) |
| `$country` | `string` | `DK` | `DK` = Denmark, `GL` = Greenland, `FO` = Faroe Islands |

## 🌤 Icons

When getting weather data from a [location](#location-by-id), the response will contain an `$icon` value. The purpose of this value is to determine which icon represents the current weather conditions.

In the table below is a list of all possible icons and values. Each icon is associated with a suggested emoji or image. 

I would recommend downloading the free icon pack from [Pixel Perfect](https://www.flaticon.com/packs/weather-97), since it's one of the few ones, that both contains a day and night version of each condition - while still being free.

### Day _<span style="font-weight:normal">(after sunrise)</span>_

| Condition | Value | Emoji | Image | 
| :--- | :--- | :---: | :---: |
| Clear | `clear` | ☀️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear.svg" height="33"> |
| Partly cloudy | `partly-cloudy` | ⛅️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/partly-cloudy.svg" height="33"> |
| Cloudy | `cloudy` | ☁️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/cloudy.svg" height="33"> |
| Foggy or misty | `foggy` | 🌫 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/foggy.svg" height="33"> |
| Thunderstorm | `thunderstorm` |️️ ⛈ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/thunderstorm.svg" height="33"> |
| Clear with light rain | `clear-light-rain` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-light-rain.svg" height="33"> |
| Light rain | `light-rain` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/light-rain.svg" height="33"> |
| Clear with heavy rain | `clear-heavy-rain` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-heavy-rain.svg" height="33"> |
| Heavy rain | `heavy-rain` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/heavy-rain.svg" height="33"> |
| Clear with light sleet | `clear-light-sleet` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-sleet.svg" height="33"> |
| Light sleet | `light-sleet` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/sleet.svg" height="33"> |
| Clear with heavy sleet | `clear-heavy-sleet` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-sleet.svg" height="33"> |
| Heavy sleet | `heavy-sleet` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/sleet.svg" height="33"> |
| Clear with light snow | `clear-light-snow` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-snow.svg" height="33"> |
| Light snow | `light-snow` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/snow.svg" height="33"> |
| Clear with heavy snow | `clear-heavy-snow` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-snow.svg" height="33"> |
| Heavy snow | `heavy-snow` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/snow.svg" height="33"> |
| Blowing snow | `blowing-snow` |️️ 🌬 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/blowing-snow.svg" height="33"> |

### Night _<span style="font-weight:normal">(after sunset)</span>_

| Condition | Value | Emoji | Icon
| :--- | :--- | :---: | :---: |
| Clear | `clear-night` | 🌕️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-night.svg" height="33"> |
| Partly cloudy | `partly-cloudy-night` | ⛅️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/partly-cloudy-night.svg" height="33"> |
| Cloudy | `cloudy-night` | ☁️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/cloudy.svg" height="33"> |
| Foggy or misty | `foggy-night` | 🌫 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/foggy.svg" height="33"> |
| Thunderstorm | `thunderstorm-night` |️️ ⛈ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/thunderstorm.svg" height="33"> |
| Clear with light rain | `clear-light-rain-night` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-light-rain-night.svg" height="33"> |
| Light rain | `light-rain-night` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/light-rain.svg" height="33"> |
| Clear with heavy rain | `clear-heavy-rain-night` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-heavy-rain-night.svg" height="33"> |
| Heavy rain | `heavy-rain-night` |️ 🌧 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/heavy-rain.svg" height="33"> |
| Clear with light sleet | `clear-light-sleet-night` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-sleet-night.svg" height="33"> |
| Light sleet | `light-sleet-night` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/sleet.svg" height="33"> |
| Clear with heavy sleet | `clear-heavy-sleet-night` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-sleet-night.svg" height="33"> |
| Heavy sleet | `heavy-sleet-night` |️️ 🌨 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/sleet.svg" height="33"> |
| Clear with light snow | `clear-light-snow-night` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-snow-night.svg" height="33"> |
| Light snow | `light-snow-night` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/snow.svg" height="33"> |
| Clear with heavy snow | `clear-heavy-snow-night` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/clear-snow-night.svg" height="33"> |
| Heavy snow | `heavy-snow-night` |️️ ☃️ | <img src="https://rugaard.github.io/packages/dmi/weather-icons/snow.svg" height="33"> |
| Blowing snow | `blowing-snow-night` |️️ 🌬 | <img src="https://rugaard.github.io/packages/dmi/weather-icons/blowing-snow.svg" height="33"> |

## 🏛 Municipalities

Denmark is split into 98 municipalities. In the list below are all the municipalities and their corresponding ID.

| Name | ID | Name | ID | Name | ID | Name | ID |
| :--- | :---: | :--- | :---: | :--- | :---: | :--- | :---: |
| Albertslund | 165 | Allerød | 201 | Assens | 420 | Ballerup | 151 |
| Billund | 530 | Bornholm | 400 | Brøndby | 153 | Brønderslev | 810 |
| Dragør | 155 | Egedal | 240 | Esbjerg | 561 | Fanø | 563 |
| Favrskov | 710 | Faxe | 320 | Fredensborg | 210 | Fredericia | 607 |
| Frederiksberg | 147 | Frederikshavn | 813 | Frederikssund | 250 | Furesø | 190 |
| Faaborg-Midtfyn | 430 | Gentofte | 157 | Gladsaxe | 159 | Glostrup | 161 |
| Greve | 253 | Gribskov | 270 | Guldborgsund | 376 | Haderslev | 510 |
| Halsnæs | 260 | Hedensted | 766 | Helsingør | 217 | Herlev | 163 |
| Herning | 657 | Hillerød | 219 | Hjørring | 860 | Holbæk | 316 |
| Holstebro | 661 | Horsens | 615 | Hvidovre | 167 | Høje-Taastrup | 169 |
| Hørsholm | 223 | Ikast-Brande | 756 | Ishøj | 183 | Jammerbugt | 849 |
| Kalundborg | 326 | Kerteminde | 440 | Kolding | 621 | København | 101 |
| Køge | 259 | Langeland | 482 | Lejre | 350 | Lemvig | 665 |
| Lolland | 360 | Lyngby-Taarbæk | 173 | Læsø | 825 | Mariagerfjord | 846 |
| Middelfart | 410 | Morsø | 773 | Norddjurs | 707 | Nordfyns | 480 |
| Nyborg | 450 | Næstved | 390 | Odder | 727 | Odense | 461 |
| Odsherred | 306 | Randers | 730 | Rebild | 840 | Ringkøbing-Skjern | 760 |
| Ringsted | 329 | Roskilde | 265 | Rudersdal | 230 | Rødovre | 175 |
| Samsø | 741 | Silkeborg | 740 | Skanderborg | 746 | Skive | 779 |
| Slagelse | 330 | Solrød | 269 | Sorø | 340 | Stevns | 336 |
| Struer | 671 | Svendborg | 479 | Syddjurs | 706 | Sønderborg | 540 |
| Thisted | 787 | Tønder | 550 | Tårnby | 185 | Vallensbæk | 187 |
| Varde | 573 | Vejen | 575 | Vejle | 630 | Vesthimmerland | 820 |
| Viborg | 791 | Vordingborg | 390 | Ærø | 492 | Aabenraa | 580 |
| Aalborg | 851 | Aarhus

## 🗣 Frequently Asked Questions (FAQ)

#### How do I find the ID of a pre-defined location?

There are two ways to find it:

1. Use this package's [search endpoint](#search-locations).

2. Go to [DMI's website](https://www.dmi.dk/) and use the search feature in the top right corner. If your desired location pops up; click on it and you will be directed to the locations page. You can now copy/paste the ID from the locations URL.
> https://<span></span>www.dmi.dk/lokation/show/DK/**`2618425`**/København/

#### What is this `Tightenco\Collect\Support\Collection` class and how does it work?

All endpoints returns data within a `Tightenco\Collect\Support\Collection` class. The class is a port of the popular `Collection` class from [Laravel](https://laravel.com).

Please refer to [Laravel](https://laravel.com)'s detailed documentation, to learn more about how you work with a `Collection`:<br>
[https://laravel.com/docs/master/collections](https://laravel.com/docs/master/collections)

## 🗺 Roadmap

#### Internal caching

Some endpoints, like [National forecasts](#national-forecast), [sunrise and sunset](#sun-times) and [pollen measurements](#pollen) are endpoints which doesn't change/update very often.

By implementing some form of internal caching, we could cache these kind of endpoints. This would increase the response time and we would avoid making unnecessary requests to DMI. 

## 🚓 License
This package is licensed under a [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 (CC BY-NC-ND 4.0)](https://creativecommons.org/licenses/by-nc-nd/4.0/).

<a rel="license" href="https://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a>
