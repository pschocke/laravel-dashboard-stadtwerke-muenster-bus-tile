<x-dashboard-tile :position="$position" :refresh-interval="60">
    <div class="grid grid-rows-auto-1 gap-2 h-full">
        <div class="flex justify-center items-center h-10">
            <div class="text-3xl leading-none w-10">🚎</div>
            <div class="text-lg leading-none">{{ $name }}</div>
        </div>
        <ul class="self-center | divide-y-2">
            @forelse($station as $data)
                <li class="grid grid-cols-1-auto py-1">
                    <span class="truncate"
                          title="{{ $data['linientext'] }} {{ $data['richtungstext'] }}"
                    >
                        {{ $data['linientext'] }} {{ $data['richtungstext'] }}
                    </span>
                    <span>
                        <span class="font-bold tabular-nums">
                            {{ $data['tatsaechliche_abfahrtszeit'] }} ({{ $data['delay'] }})
                        </span>
                    </span>
                </li>
            @empty
                <li class="grid grid-cols-1-auto py-1">
                    <span>
                        <span>Leider keine Abfahrten in den nächsten 30 Minuten
                        </span>
                    </span>
                </li>
            @endforelse
        </ul>
    </div>
</x-dashboard-tile>