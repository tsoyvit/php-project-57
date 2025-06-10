@extends('layouts.app')
@section('h1', __('task_statuses.change_status'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 ml-0 p-0">
                {{ html()->modelForm($taskStatus, 'PATCH', route('task_statuses.update', $taskStatus))
                    ->class('needs-validation')
                    ->novalidate()
                    ->open() }}

                @include('task_status.form')

                <div class="mb-3">
                    {{ html()->submit(__('app.update'))->class('btn btn-primary') }}
                </div>

                {{ html()->closeModelForm() }}
            </div>
        </div>
    </div>

@endsection
