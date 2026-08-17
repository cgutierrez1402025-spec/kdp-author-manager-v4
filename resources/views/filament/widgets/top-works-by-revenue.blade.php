@php($works = $this->getWorks())
<div class="p-4 bg-white rounded-lg shadow">
    <h3 class="text-sm font-medium text-gray-500 mb-2">Top 10 Obras por Ingresos</h3>
    @if(empty($works))
        <p class="text-gray-400">No hay datos disponibles</p>
    @else
        <ol class="space-y-2">
            @foreach($works as $work)
                <li class="flex justify-between text-sm">
                    <span class="text-gray-900">{{ $work['title'] }}</span>
                    <span class="font-medium text-amber-600">{{ number_format($work['revenue'], 2) }} €</span>
                </li>
            @endforeach
        </ol>
    @endif
</div>
