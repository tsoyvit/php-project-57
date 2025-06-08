@extends('layouts.app')
@section('h1', __('label.Changing the label'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 ml-0 p-0">

                {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))
                    ->class('needs-validation')
                    ->novalidate()
                    ->open() }}

                @include('label.form')

                <div class="mb-3">
                    {{ html()->submit(__('label.update'))->class('btn btn-primary') }}
                </div>

                {{ html()->closeModelForm() }}

            </div>
        </div>
    </div>

@endsection
