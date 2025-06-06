@extends('layouts.app')
@section('h1', __('task.create task'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 ml-0 p-0">

                {{ html()->modelForm($task, 'POST', route('tasks.store'))
                    ->class('needs-validation')
                    ->novalidate()
                    ->open() }}

                <div class="mb-3">
                    {{ html()->label(__('task.name'), 'name')->class('form-label') }}
                    {{ html()->text('name')->class('form-control')->required() }}
                    @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    {{ html()->label(__('task.description'), 'description')->class('form-label') }}
                    {{ html()->textarea('description')->class('form-control') }}
                    @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    {{ html()->label(__('task.status'), 'status_id')->class('form-label') }}
                    {{ html()->select('status_id', ['' => ''] + $taskStatuses->toArray())
                        ->class('form-control') }}
                    @error('status_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    {{ html()->label(__('task.assignee'), 'assigned_to_id')->class('form-label') }}
                    {{ html()->select('assigned_to_id', ['' => ''] + $assignees->toArray())
                        ->class('form-control') }}
                    @error('assigned_to_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    {{ html()->submit(__('task.create'))->class('btn btn-primary') }}
                </div>

                {{ html()->closeModelForm() }}

            </div>
        </div>
    </div>


@endsection
