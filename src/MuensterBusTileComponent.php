<?php

namespace Pschocke\MuensterBusTile;

use Livewire\Component;
use Spatie\Dashboard\Models\Tile;

class MuensterBusTileComponent extends Component
{
    public string $position;
    public string $station_id;
    public string $name;

    public function mount(string $position, string $station, string $name)
    {
        $this->position = $position;
        $this->station_id = $station;
        $this->name = $name;
    }

    public function render()
    {
        return view('dashboard-muenster-bus-tile::tile', [
            'station' => Tile::firstOrCreateForName('muenster-bus-tile')->getData($this->station_id) ?: [],
        ]);
    }
}