<?php

namespace Navel\LaravelRoles;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Service provider
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrations();
        $this->publishResources();
    }

    /**
     * Load the migrations
     *
     * @return  void
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('/database/migrations'),
        ], 'laravel-roles-migrations');

        $this->publishes([
            __DIR__ . '/../database/Seeders' => base_path('/database/seeders'),
        ], 'laravel-roles-seeders');
    }

    /**
     * Allow the resources to be published
     *
     * @return  void
     */
    protected function publishResources()
    {
        $this->publishes([
            __DIR__ . '/../resources' => base_path('/resources'),
        ], 'laravel-roles-resources');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
