@extends('layouts.app')
@section('h1', __('task_statuses.h1'))
@section('content')



    @auth
    <div class="mb-4">
        <a class="btn btn-primary" href="{{ route('task_statuses.create') }}">
            {{ __('task_statuses.create') }}
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
                        <th>{{ __('task_statuses.name') }}</th>
                        <th>{{ __('task_statuses.created_at') }}</th>
                        @auth
                        <th>{{ __('task_statuses.actions') }}</th>
                        @endauth
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($taskStatuses as $taskStatus)
                        <tr>
                            <td>{{ $taskStatus->id }}</td>
                            <td>{{ $taskStatus->name }}</td>
                            <td>{{ $taskStatus->created_at->format('d.m.Y') }}</td>

                            @auth
                            <td>
                                <div class="d-flex gap-2">

                                    <a href="{{ route('task_statuses.edit', $taskStatus) }}"
                                       class="btn btn-link text-primary p-0 text-decoration-none">
                                        {{ __('task.change') }}
                                    </a>

                                    <form action="{{ route('task_statuses.destroy', $taskStatus) }}" method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-link text-danger p-0 text-decoration-none"
                                                onclick="return confirm('{{ __('task_statuses.confirm_delete') }}')">
                                            {{ __('task_statuses.delete') }}
                                        </button>
                                    </form>

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

@endsection
