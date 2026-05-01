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
     * Register service provider.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->singleton(abstract: 'rugaard.dmi', concrete: fn () => new DMI);
        $this->app->bind(abstract: DMI::class, concrete: fn ($app) => $app['rugaard.dmi']);
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
