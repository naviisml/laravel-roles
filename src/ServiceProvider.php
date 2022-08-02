<?php

namespace Naviisml\Laravel\Roles;

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
        $this->registerCommands();
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

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Naviisml\Laravel\Roles\Commands\RoleAssign::class,
                \Naviisml\Laravel\Roles\Commands\RoleRemove::class,
            ]);
        }
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
