@extends('layouts.app')
@section('h1', __('task_statuses.change_status'))
@section('content')

    {{ html()->modelForm($taskStatus, 'PATCH', route('task_statuses.update', $taskStatus))
        ->class('w-50')
        ->novalidate()
        ->open() }}
    <div class="flex flex-col">
        @include('task_status.form')
        <div class="mb-3">
            {{ html()->submit(__('app.update'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
        </div>
    </div>
    {{ html()->closeModelForm() }}

@endsection
