<div class="space-y-3">
    @if(empty($promotions))
        <p class="text-gray-500 dark:text-gray-400">No active promotions found.</p>
    @else
        @foreach($promotions as $promotion)
            <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $promotion['promotion_name'] ?? 'Untitled' }}
                        </h4>
                        <p class="text-sm text-gray-500">{{ $promotion['work_title'] ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400">{{ $promotion['marketplace'] ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-semibold {{ $promotion['roi'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $promotion['roi'] }}% ROI
                        </span>
                        <p class="text-xs text-gray-500">
                            {{ number_format($promotion['total_revenue'], 2) }} € / {{ number_format($promotion['total_cost'], 2) }} €
                        </p>
                    </div>
                </div>
                @if($promotion['end_date'])
                    <p class="text-xs text-gray-400 mt-2">
                        Ends: {{ \Carbon\Carbon::parse($promotion['end_date'])->format('M d, Y') }}
                    </p>
                @endif
            </div>
        @endforeach
    @endif
</div>