@extends('layouts.app')
@section('h1', __('label.labels'))
@section('content')

    @include('partials.flash')

    @auth
        <div>
            <a href="{{ route('labels.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('label.create label') }}</a>
        </div>
    @endauth


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
                    @auth
                        <form action="{{ route('labels.destroy', $label) }}" method="POST" class="inline-block ml-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('{{ __('label.are you sure?') }}')">
                                {{ __('label.delete') }}
                            </button>
                        </form>

                        <a class="inline-block text-blue-500 hover:text-blue-900 ml-0"
                           href="{{ route('labels.edit', $label) }}">
                            {{ __('label.change') }}
                        </a>
                    @endauth
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection
