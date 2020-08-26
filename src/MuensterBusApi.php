<?php


namespace Pschocke\MuensterBusTile;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Dashboard\Models\Tile;

class MuensterBusApi
{
    private string $basePath = "https://rest.busradar.conterra.de/prod/haltestellen/%d/abfahrten?sekunden=1800";

    public function getStations(array $station_ids): void
    {
        foreach ($station_ids as $name => $real_station_id) {
            $stations = Collection::wrap($real_station_id);

            $fullData = collect();

            $stations->each(function($station) use ($fullData) {
                $fullData->add(
                    $this->getBusItemsForStation($station)
                );
            });

            $fullData = $fullData
            ->flatten(1)
            ->sortBy(function ($item) {
                return intval($item['tatsaechliche_abfahrtszeit_int']);
            })
            ->values();

            Tile::firstOrCreateForName('muenster-bus-tile')->putData($name, $fullData);
        }
    }

    public function getBusItemsForStation(string $station_id): Collection
    {
        $response = collect(Http::get(sprintf($this->basePath, $station_id))->json());

        return $response
            ->map(function ($item) {
                $delay = Carbon::parse($item['abfahrtszeit'])->diffInMinutes(Carbon::parse($item['tatsaechliche_abfahrtszeit']), false);
                return [
                    'tatsaechliche_abfahrtszeit' => Carbon::parse($item['tatsaechliche_abfahrtszeit'], 'UTC')->setTimezone(config('app.timezone'))->format('H:i'),
                    'tatsaechliche_abfahrtszeit_int' => $item['tatsaechliche_abfahrtszeit'],
                    'delay' => Str::startsWith($delay, '-') ? $delay : "+" . $delay,
                    'linientext' => $item['linientext'],
                    'richtungstext' => $item['richtungstext']
                ];
            });
    }
}