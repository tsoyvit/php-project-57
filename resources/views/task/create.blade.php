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

                @include('task.form')

                <div class="mb-3">
                    {{ html()->submit(__('task.create'))->class('btn btn-primary') }}
                </div>

                {{ html()->closeModelForm() }}

            </div>
        </div>
    </div>

@endsection
