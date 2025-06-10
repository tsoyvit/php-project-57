@extends('layouts.app')
{{--@section('h1', __('task.Viewing an issue') . $task->name))--}}
@section('content')

    <div class="card border-light mb-3">
        <div class="card-header">
            <h2 class="fs-4 d-flex align-items-center">
                {{ __('task.Viewing an issue') }} {{ $task->name }}
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm"><i class="bi bi-gear fs-5"></i></a>
            </h2>
        </div>

        <div class="card-body">
            <p class="mb-2">
                <span class="fw-bold">{{ __('task.name') }}:</span>
                {{ $task->name }}
            </p>
            <p class="mb-2">
                <span class="fw-bold">{{ __('task.status') }}:</span>
                {{ $task->status->name }}
            </p>
            <p class="mb-2">
                <span class="fw-bold">{{ __('task.description') }}:</span>
                {{ $task->description }}
            </p>

            <div class="mb-2">
                <span class="fw-bold">{{ __('label.labels') }}:</span>

                @foreach($task->labels as $label)
                <span class="badge bg-primary d-inline-flex align-items-center fw-bold text-uppercase me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="me-1" viewBox="0 0 24 24">
                        <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ $label->name }}
                </span>
                @endforeach

            </div>

        </div>
    </div>

@endsection
