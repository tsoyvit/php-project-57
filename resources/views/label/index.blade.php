@extends('layouts.app')
@section('h1', __('label.labels'))
@section('content')

    @auth
        <div class="mb-4">
            <a class="btn btn-primary" href="{{ route('labels.create') }}">
                {{ __('label.create label') }}
            </a>
        </div>
    @endauth

    <div class="card shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive rounded-1">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
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
                        <tr>
                            <td>{{ $label->id }}</td>
                            <td>{{ $label->name }}</td>
                            <td>{{ $label->description }}</td>
                            <td>{{ $label->created_at->format('d.m.Y') }}</td>

                            @auth
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('labels.edit', $label) }}"
                                           class="btn btn-link text-primary p-0 text-decoration-none">
                                            {{ __('label.change') }}
                                        </a>

                                        <form action="{{ route('labels.destroy', $label) }}" method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-link text-danger p-0 text-decoration-none"
                                                    onclick="return confirm('{{ __('label.are you sure?') }}')">
                                                {{ __('label.delete') }}
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            @endauth

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
