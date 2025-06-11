@extends('layouts.app')
@section('h1', __('task.tasks'))
@section('content')

    @include('partials.flash')

    <div class="w-full flex items-center justify-between">
        <div>
            {{ html()->form('GET')->route('tasks.index')->open() }}

            <div class="flex">
                {{ html()->select('filter[status_id]', $statuses->toArray(), $inputFilter['status_id'] ?? null)
                    ->class('rounded border-gray-300')
                    ->placeholder(__('task.status')) }}

                {{ html()->select('filter[created_by_id]', $users->toArray(), $inputFilter['created_by_id'] ?? null)
                    ->class('rounded border-gray-300')
                    ->placeholder(__('task.author')) }}

                {{ html()->select('filter[assigned_to_id]', $users->toArray(), $inputFilter['assigned_to_id'] ?? null)
                    ->class('rounded border-gray-300')
                    ->placeholder(__('task.assignee')) }}

                {{ html()->submit(__('task.apply'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2') }}
            </div>

            {{ html()->form()->close() }}
        </div>

        @auth
            <div class="ml-0">
                <a href="{{ route('tasks.create') }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    {{ __('task.create task') }}
                </a>
            </div>
        @endauth

    </div>

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
        <tr>
            <th>ID</th>
            <th>{{ __('task.status') }}</th>
            <th>{{ __('task.name') }}</th>
            <th>{{ __('task.author') }}</th>
            <th>{{ __('task.assignee') }}</th>
            <th>{{ __('task.created at') }}</th>

            @auth
                <th>{{ __('task.actions') }}</th>
            @endauth

        </tr>
        </thead>

        <tbody>

        @foreach($tasks as $task)

            <tr class="border-b border-dashed text-left">
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td>
                <td>
                    <a class="text-blue-500 hover:text-blue-900" href="{{ route('tasks.show', $task) }}">
                        {{ $task->name }}
                    </a>
                </td>
                <td>{{ $task->creator->name }}</td>
                <td>{{ $task->assignee->name ?? ''}}</td>
                <td>{{ $task->created_at->format('d.m.Y') }}</td>
                <td>

                    @auth
                        @can('delete', $task)
                            <a class="text-red-600 hover:text-ted-900" href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('task.are you sure?') }}" data-method="delete" rel="nofollow">{{ __('task.delete') }}</a>
                        @endcan

                        <a href="{{ route('tasks.edit', $task) }}"
                           class="inline-block text-blue-500 hover:text-blue-900 ml-0">
                            {{ __('task.change') }}
                        </a>
                    @endauth
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $tasks->links() }}

@endsection
