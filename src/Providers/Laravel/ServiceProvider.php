<?php
declare(strict_types=1);

namespace Rugaard\DMI\Providers\Laravel;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Rugaard\DMI\DMI;

/**
 * Class ServiceProvider
 *
 * @package Rugaard\DMI\Providers\Laravel
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot service provider.
     *
     * @return void
     */
    public function boot() : void
    {
        // Publish config file.
        $this->publishes([
            __DIR__ . '/config.php' => config_path('dmi.php'),
        ], 'dmi');

        // Use package configuration as fallback
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'dmi'
        );
    }

    /**
     * Register service provider.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->singleton('rugaard.dmi', function ($app) {
            // Get configuration.
            $config = config('dmi');

            return new DMI(
                $config['defaultLocationId'] ?? null,
                $config['client'] ?? null
            );
        });

        $this->app->bind(DMI::class, function ($app) {
            return $app['rugaard.dmi'];
        });
    }
    /**
     * Get the services provided by this provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return ['rugaard.dmi'];
    }
}