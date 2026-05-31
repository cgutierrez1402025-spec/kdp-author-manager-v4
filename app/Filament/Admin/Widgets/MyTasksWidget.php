<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;

class MyTasksWidget extends Widget
{
    protected string $view = 'filament.widgets.my-tasks';

    protected int $tasksLimit = 10;

    public function getTasksProperty(): array
    {
        return Task::with('work')
            ->where('assigned_to', auth()->id())
            ->orWhere('created_by', auth()->id())
            ->orderBy('due_date')
            ->orderBy('priority')
            ->limit($this->tasksLimit)
            ->get()
            ->map(fn (Task $task) => [
                'id' => $task->id,
                'title' => $task->title,
                'work_title' => $task->work->title_public ?? null,
                'priority' => $task->priority,
                'due_date' => $task->due_date,
                'is_overdue' => $task->isOverdue(),
            ])
            ->values()
            ->all();
    }
}