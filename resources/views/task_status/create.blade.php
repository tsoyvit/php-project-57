@extends('layouts.app')
@section('h1', __('task_statuses.create'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 ml-0 p-0">
                {{ html()->modelForm($taskStatus, 'POST', route('task_statuses.store'))
                    ->class('needs-validation')
                    ->novalidate()
                    ->open() }}

                @include('task_status.form')

                <div class="mb-3">
                    {{ html()->submit(__('app.create'))->class('btn btn-primary') }}
                </div>

                {{ html()->closeModelForm() }}
            </div>
        </div>
    </div>

@endsection
