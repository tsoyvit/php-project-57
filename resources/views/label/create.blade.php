@extends('layouts.app')
@section('h1', __('label.create label'))
@section('content')

    {{ html()->modelForm($label, 'POST', route('labels.store'))
        ->class('w-50')
        ->novalidate()
        ->open() }}
    <div class="flex flex-col">
        @include('label.form')
        <div class="mb-2">
            {{ html()->submit(__('label.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
        </div>
    </div>
    {{ html()->closeModelForm() }}

@endsection
