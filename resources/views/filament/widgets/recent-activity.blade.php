<div class="p-4 bg-white rounded-lg shadow">
    <h3 class="text-sm font-medium text-gray-500 mb-2">Actividad Reciente</h3>
    @php($activities = $this->getActivities())
    @if(empty($activities))
        <p class="text-gray-400">No hay actividad reciente</p>
    @else
        <div class="space-y-2">
            @foreach($activities as $activity)
                <div class="text-sm">
                    <span class="font-medium text-gray-900">{{ $activity['user'] }}</span>
                    <span class="text-gray-500"> {{ $activity['action'] }}</span>
                    <span class="font-medium text-gray-700"> {{ $activity['description'] }}</span>
                    <span class="text-xs text-gray-400">{{ $activity['created_at'] }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
