<div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
    <h3 class="text-sm font-medium text-gray-500 mb-2">Períodos KDP Select que Vencen</h3>
    @if(empty($expiring_periods))
        <p class="text-gray-400">No hay períodos vencidos próximamente</p>
    @else
        <div class="space-y-2">
            @foreach($expiring_periods as $period)
                <div class="text-sm">
                    <span class="text-gray-900 dark:text-gray-100">{{ $period['work_title'] }}</span>
                    <div class="text-xs text-gray-500">
                        Vence: {{ $period['end_date'] }} ({{ $period['remaining_days'] }} días)
                        - {{ $period['free_days_remaining'] }} días gratis restantes
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>