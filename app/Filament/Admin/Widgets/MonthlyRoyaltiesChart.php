<?php

namespace App\Filament\Admin\Widgets;

use App\Models\RoyaltyEntry;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class MonthlyRoyaltiesChart extends Widget
{
    protected string $view = 'filament.widgets.monthly-royalties-chart';

    public function getChartDataProperty(): array
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return [
                'month' => $month,
                'year' => now()->subMonths(12 - $month)->year,
            ];
        })->reverse();

        $entries = RoyaltyEntry::selectRaw('year, month, SUM(total_royalty) as total')
            ->where('year', '>=', now()->subYear()->year)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($entry) => "{$entry->year}-{$entry->month}");

        $data = [];
        $labels = [];

        foreach ($months as $m) {
            $key = "{$m['year']}-{$m['month']}";
            $labels[] = $m['month'] . '/' . substr($m['year'], 2, 2);
            $data[] = $entries->get($key)?->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}