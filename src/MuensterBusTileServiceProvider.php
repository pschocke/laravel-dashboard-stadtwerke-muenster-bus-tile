<?php

namespace Pschocke\MuensterBusTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class MuensterBusTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchMuensterBusStationsCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/dashboard-muenster-bus-tile'),
        ], 'dashboard-muenster-bus-tile-views');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dashboard-muenster-bus-tile');

        Livewire::component('muenster-bus-tile', MuensterBusTileComponent::class);
    }
}