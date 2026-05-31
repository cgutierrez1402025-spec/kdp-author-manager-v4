<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach($stats as $key => $value)
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-500 truncate" title="{{ $key }}">
                @switch($key)
                    @case('total_works') Total Obras @break
                    @case('monthly_revenue') Ingresos del Mes @break
                    @case('active_publications') Publicaciones Activas @break
                    @case('active_promotions') Promociones Activas @break
                    @default {{ ucfirst(str_replace('_', ' ', $key)) }}
                @endswitch
            </h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                @if($key === 'monthly_revenue')
                    {{ number_format($value, 2) }} €
                @else
                    {{ number_format($value) }}
                @endif
            </p>
        </div>
    @endforeach
</div>