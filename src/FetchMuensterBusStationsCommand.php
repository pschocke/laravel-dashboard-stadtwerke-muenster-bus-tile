<?php

namespace Pschocke\MuensterBusTile;

use Illuminate\Console\Command;

class FetchMuensterBusStationsCommand extends Command
{
    protected $signature = 'dashboard:fetch-muenster-bus-stations';
    protected $description = 'Fetch bus departures';

    public function handle(MuensterBusApi $api): void
    {
        $api->getStations(config('dashboard.tiles.muenster-bus.stations', []));
    }
}