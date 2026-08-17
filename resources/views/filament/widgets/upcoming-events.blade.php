@php($events = $this->getEventsProperty())
<div class="space-y-3">
    @if(empty($events))
        <p class="text-gray-500">No hay eventos próximos en los próximos 30 días.</p>
    @else
        @foreach($events as $event)
            <div class="p-3 bg-white rounded-lg border border-gray-200">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $event['title'] }}</h4>
                        <p class="text-sm text-gray-500">{{ $event['location_name'] }}, {{ $event['city'] }}</p>
                    </div>
                    <span class="text-xs text-gray-400">
                        {{ $event['event_date'] ? \Carbon\Carbon::parse($event['event_date'])->format('d/m/Y') : 'N/A' }}
                    </span>
                </div>
                @if($event['total_copies_sold'])
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $event['total_copies_sold'] }} copias vendidas • {{ number_format($event['total_income'], 2) }} €
                    </p>
                @endif
            </div>
        @endforeach
    @endif
</div>
