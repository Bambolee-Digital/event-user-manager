<?php

namespace BamboleeDigital\EventUserManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EventUserManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/event-user-manager.php' => config_path('event-user-manager.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                // Register any console commands here
            ]);
        }

        // if (config('event-user-manager.filament.enabled')) {
        //     $this->loadViewsFrom(__DIR__.'/Filament/Resources', 'event-user-manager');
        // }

        // if (class_exists(\Filament\Facades\Filament::class)) {
        //     \Filament\Facades\Filament::registerResources([
        //         EventResource::class,
        //         RecurrencePatternResource::class,
        //         // Register other resources her
        //     ]);
        // }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/event-user-manager.php', 'event-user-manager'
        );

        $this->app->singleton('event-user-manager.notification', function ($app) {
            return new Services\NotificationService();
        });
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('event-user-manager.routes.prefix'),
            'middleware' => config('event-user-manager.routes.middleware', 'api'),
        ];
    }
}