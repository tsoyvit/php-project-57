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
        </div>
    </div>

@endsection
