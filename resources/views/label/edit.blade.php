@extends('layouts.app')
@section('h1', __('label.Changing the label'))
@section('content')

    {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))
        ->class('w-50')
        ->novalidate()
        ->open() }}
    <div class="flex flex-col">
        @include('label.form')
        <div class="mb-3">
            {{ html()->submit(__('label.update'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
        </div>
    </div>
    {{ html()->closeModelForm() }}
@endsection
