@extends('layouts.app')
@section('h1', __('label.create label'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 ml-0 p-0">

                {{ html()->modelForm($label, 'POST', route('labels.store'))
                    ->class('needs-validation')
                    ->novalidate()
                    ->open() }}

                @include('label.form')

                <div class="mb-3">
                    {{ html()->submit(__('label.create'))->class('btn btn-primary') }}
                </div>

                {{ html()->closeModelForm() }}

            </div>
        </div>
    </div>


@endsection
