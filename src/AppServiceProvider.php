<?php

namespace LaravelEnso\Calendar;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Calendar\App\Commands\SendReminders;
use LaravelEnso\Calendar\App\Services\Calendars;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        'calendars' => Calendars::class,
    ];

    public function boot()
    {
        $this->load()
            ->publishProvider()
            ->publishFactories()
            ->publishMail()
            ->commands(SendReminders::class);
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/calendar');

        return $this;
    }

    private function publishProvider()
    {
        $this->publishes([
            __DIR__.'/../stubs/CalendarServiceProvider.stub' => app_path(
                'Providers/CalendarServiceProvider.php'
            ),
        ], 'calendar-provider');

        return $this;
    }

    private function publishFactories()
    {
        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'calendar-factories');

        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'enso-factories');

        return $this;
    }

    private function publishMail()
    {
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/laravel-enso/calendar'),
        ], 'calendar-mail');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/laravel-enso/calendar'),
        ], 'enso-mail');

        return $this;
    }
}
