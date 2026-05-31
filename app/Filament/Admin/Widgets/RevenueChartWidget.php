<?php

namespace App\Filament\Admin\Widgets;

use App\Models\RoyaltyEntry;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class RevenueChartWidget extends Widget
{
    protected string $view = 'filament.widgets.revenue-chart';

    protected static ?int $sort = 2;

    public function getChartData(): array
    {
        return Cache::remember('dashboard_revenue_chart', 3600, function () {
            $months = collect(range(1, 6))->map(fn ($i) => now()->subMonths($i)->startOfMonth());

            $entries = RoyaltyEntry::selectRaw('year, month, SUM(total_royalty) as total')
                ->where(function ($query) {
                    $query->where('year', '>', now()->subYear()->year)
                        ->orWhere(function ($q) {
                            $q->where('year', now()->subYear()->year)
                              ->where('month', '>=', now()->subMonths(6)->month);
                        });
                })
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get()
                ->keyBy(fn ($e) => "{$e->year}-{$e->month}");

            $labels = [];
            $data = [];

            foreach ($months as $date) {
                $key = $date->format('Y-m');
                $labels[] = $date->format('M Y');
                $data[] = $entries->get($key)?->total ?? 0;
            }

            return [
                'labels' => $labels,
                'data' => $data,
            ];
        });
    }
}