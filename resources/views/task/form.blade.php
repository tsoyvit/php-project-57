<div>
    {{ html()->label(__('task.name'), 'name') }}
</div>

<div class="mb-2">
    {{ html()->text('name')->class('rounded border-gray-300 w-1/3')->required() }}
    @error('name')
    <div class="text-rose-600">{{ $message }}</div>
    @enderror
</div>

<div>
    {{ html()->label(__('task.description'), 'description') }}
</div>

<div class="mb-2">
    {{ html()->textarea('description')->class('rounded border-gray-300 w-1/3 h-32') }}
    @error('description')
    <div class="text-rose-600">{{ $message }}</div>
    @enderror
</div>

<div>
    {{ html()->label(__('task.status'), 'status_id') }}
</div>

<div class="mb-2">
    {{ html()->select('status_id', ['' => ''] + $taskStatuses->toArray())
        ->class('rounded border-gray-300 w-1/3') }}
    @error('status_id')
    <div class="text-rose-600">{{ $message }}</div>
    @enderror
</div>

<div>
    {{ html()->label(__('task.assignee'), 'assigned_to_id') }}
</div>

<div class="mb-2">
    {{ html()->select('assigned_to_id', ['' => ''] + $assignees->toArray())
        ->class('rounded border-gray-300 w-1/3') }}
</div>

<div>
    {{ html()->label(__('label.labels'))->for('labels') }}
</div>

<div class="mb-2">
    {{ html()->select('labels[]', $labels->toArray(), $task->labels->pluck('id')->toArray())
        ->multiple()
        ->class('rounded border-gray-300 w-1/3 h-32')
        ->attribute('aria-label', 'Multiple select example')
        ->id('labels')
    }}
</div>
