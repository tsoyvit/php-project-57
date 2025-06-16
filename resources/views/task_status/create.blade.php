@extends('layouts.app')
@section('h1', __('task_statuses.create'))
@section('content')

    {{ html()->modelForm($taskStatus, 'POST', route('task_statuses.store'))
        ->class('w-50')
        ->novalidate()
        ->open() }}
    <div class="flex flex-col">
        @include('task_status.form')
        <div class="mb-3">
            {{ html()->submit(__('app.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
        </div>
    </div>
    {{ html()->closeModelForm() }}

@endsection
