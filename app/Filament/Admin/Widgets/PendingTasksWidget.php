<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class PendingTasksWidget extends Widget
{
    protected static string $view = 'filament.widgets.pending-tasks';

    protected static ?int $sort = 6;

    public function getTasks(): array
    {
        return Cache::remember('dashboard_pending_tasks_'.auth()->id(), 3600, function () {
            return Task::where('assigned_to', auth()->id())
                ->orWhere('created_by', auth()->id())
                ->where('status', 'pending')
                ->with('work')
                ->orderBy('due_date')
                ->limit(10)
                ->get()
                ->map(fn (Task $task) => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'work_title' => $task->work->title_public ?? null,
                    'due_date' => $task->due_date?->format('d/m/Y'),
                    'is_overdue' => $task->isOverdue(),
                ])
                ->values()
                ->all();
        });
    }
}
