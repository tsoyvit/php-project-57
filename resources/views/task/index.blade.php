@extends('layouts.app')
@section('h1', __('task.tasks'))
@section('content')

    @auth
    <div class="mb-4">
        <a class="btn btn-primary" href="{{ route('tasks.create') }}">
            {{ __('task.create task') }}
        </a>
    </div>
    @endauth

    <div class="card shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
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
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->status->name }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">{{ $task->name }}</a>
                            </td>
                            <td>{{ $task->creator->name }}</td>
                            <td>{{ $task->assignee->name ?? ''}}</td>
                            <td>{{ $task->created_at->format('d.m.Y') }}</td>
                            @auth
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.edit', $task) }}"
                                           class="btn btn-link text-primary p-0 text-decoration-none">
                                            {{ __('task.change') }}
                                        </a>

                                        @can('delete', $task)
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-link text-danger p-0 text-decoration-none"
                                                    onclick="return confirm('{{ __('task.are you sure?') }}')">
                                                {{ __('task.delete') }}
                                            </button>
                                        </form>
                                        @endcan

                                    </div>
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $tasks->links() }}

@endsection
