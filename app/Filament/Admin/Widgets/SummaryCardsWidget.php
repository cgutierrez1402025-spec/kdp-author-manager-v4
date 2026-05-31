<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BookPromotion;
use App\Models\KdpSelectPeriod;
use App\Models\Publication;
use App\Models\Work;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class SummaryCardsWidget extends Widget
{
    protected string $view = 'filament.widgets.summary-cards';

    protected static ?int $sort = 1;

    public function getStats(): array
    {
        return Cache::remember('dashboard_summary_cards', 3600, function () {
            $currentMonth = now()->month;
            $currentYear = now()->year;

            return [
                'total_works' => Work::count(),
                'monthly_revenue' => \App\Models\RoyaltyEntry::where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->sum('total_royalty'),
                'active_publications' => Publication::where('status', 'published')->count(),
                'active_promotions' => BookPromotion::active()->count(),
            ];
        });
    }
}