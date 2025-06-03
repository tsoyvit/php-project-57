@extends('layouts.app')
@section('h1', __('task_statuses.create'))

@section('content')

    {{ html()->modelForm($taskStatus, 'POST', route('task_statuses.store'))
        ->class('needs-validation')
        ->novalidate()
        ->open() }}

    @include('task_status.form')

    <div class="mb-3">
        {{ html()->submit(__('app.create'))->class('btn btn-primary') }}
    </div>

    {{ html()->closeModelForm() }}

@endsection
