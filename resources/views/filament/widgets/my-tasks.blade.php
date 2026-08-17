@php($tasks = $this->getTasksProperty())
<div class="space-y-3">
    @if(empty($tasks))
        <p class="text-gray-500">No hay tareas pendientes.</p>
    @else
        @foreach($tasks as $task)
            <div class="p-3 bg-white rounded-lg border {{ $task['is_overdue'] ? 'border-red-300' : 'border-gray-200' }}">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">
                            {{ $task['title'] }}
                        </h4>
                        @if($task['work_title'])
                            <p class="text-sm text-gray-500">{{ $task['work_title'] }}</p>
                        @endif
                    </div>
                    <span class="text-xs px-2 py-1 rounded {{ $task['is_overdue'] ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                        @if($task['is_overdue'])
                            Vencida
                        @elseif($task['due_date'])
                            {{ \Carbon\Carbon::parse($task['due_date'])->format('d/m') }}
                        @endif
                    </span>
                </div>
            </div>
        @endforeach
    @endif
</div>
