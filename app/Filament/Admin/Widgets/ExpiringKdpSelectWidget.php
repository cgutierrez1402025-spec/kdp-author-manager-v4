<?php

namespace App\Filament\Admin\Widgets;

use App\Models\KdpSelectPeriod;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class ExpiringKdpSelectWidget extends Widget
{
    protected static string $view = 'filament.widgets.expiring-kdp-select';

    protected static ?int $sort = 4;

    public function getExpiringPeriods(): array
    {
        return Cache::remember('dashboard_expiring_kdp', 3600, function () {
            return KdpSelectPeriod::where('status', 'active')
                ->whereDate('end_date', '<=', now()->addDays(30))
                ->whereDate('end_date', '>=', now())
                ->with('publication.work')
                ->orderBy('end_date')
                ->limit(10)
                ->get()
                ->map(fn (KdpSelectPeriod $period) => [
                    'work_title' => $period->publication->work->title_public ?? 'N/A',
                    'end_date' => $period->end_date->format('d/m/Y'),
                    'remaining_days' => now()->diffInDays($period->end_date, false),
                    'free_days_remaining' => $period->getRemainingFreeDays(),
                ])
                ->values()
                ->all();
        });
    }
}
