@extends('layouts.app')
@section('h1', __('task.Changing the task'))
@section('content')

    {{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))
        ->class('w-50')
        ->novalidate()
        ->open() }}
    <div class="flex flex-col">
        @include('task.form')
        <div class="mb-2">
            {{ html()->submit(__('task.update'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
        </div>
    </div>
    {{ html()->closeModelForm() }}

@endsection
