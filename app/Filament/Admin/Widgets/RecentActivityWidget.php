<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ActivityLog;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class RecentActivityWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-activity';

    protected static ?int $sort = 5;

    public function getActivities(): array
    {
        return Cache::remember('dashboard_recent_activity', 3600, function () {
            return ActivityLog::with('user')
                ->latest()
                ->limit(10)
                ->get()
                ->map(fn (ActivityLog $log) => [
                    'user' => $log->user->name ?? 'Sistema',
                    'action' => $log->action,
                    'description' => $log->description,
                    'created_at' => $log->created_at->diffForHumans(),
                ])
                ->values()
                ->all();
        });
    }
}
