@extends('layouts.app')
@section('h1', __('label.labels'))
@section('content')

    @include('partials.flash')

    @can('create', App\Models\Label::class)
        <div>
            <a href="{{ route('labels.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('label.create label') }}</a>
        </div>
    @endcan


    <table class="mt-4">

        <thead class="border-b-2 border-solid border-black text-left">
        <tr>
            <th>ID</th>
            <th>{{ __('label.name') }}</th>
            <th>{{ __('label.description') }}</th>
            <th>{{ __('label.created at') }}</th>

            @auth
                <th>{{ __('label.actions') }}</th>
            @endauth
        </tr>
        </thead>

        <tbody>

        @foreach($labels as $label)
            <tr class="border-b border-dashed text-left">
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at->format('d.m.Y') }}</td>
                <td>
                    @can('delete', $label)
                        <a class="text-red-600 hover:text-red-900" href="{{ route('labels.destroy', $label->id) }}"
                           data-confirm="{{ __('label.are you sure?') }}" data-method="delete" rel="nofollow">
                            {{ __('label.delete') }}
                        </a>
                    @endcan

                    @can('update', $label)
                        <a class="inline-block text-blue-500 hover:text-blue-900 ml-0"
                           href="{{ route('labels.edit', $label) }}">
                            {{ __('label.change') }}
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection
