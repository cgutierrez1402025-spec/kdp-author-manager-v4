<?php

namespace App\Filament\Admin\Widgets;

use App\Models\RoyaltyEntry;
use App\Models\Work;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class TopWorksByRevenueWidget extends Widget
{
    protected string $view = 'filament.widgets.top-works-by-revenue';

    protected static ?int $sort = 3;

    public function getWorks(): array
    {
        return Cache::remember('dashboard_top_works', 3600, function () {
            $entries = RoyaltyEntry::selectRaw('publication_id, SUM(total_royalty) as total_revenue')
                ->whereHas('publication.work')
                ->groupBy('publication_id')
                ->orderByDesc('total_revenue')
                ->limit(10)
                ->get();

            $works = Work::whereIn('id', $entries->pluck('publication.work_id'))
                ->with('publications')
                ->get()
                ->keyBy('id');

            return $entries->map(fn ($entry) => [
                'title' => $works->get($entry->publication->work_id)?->title_public ?? 'N/A',
                'revenue' => $entry->total_revenue,
            ])->values()->all();
        });
    }
}