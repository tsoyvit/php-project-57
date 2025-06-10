@extends('layouts.app')
@section('h1', 'Привет от Хекслета!')

@section('content')

    <div class="container mb-4">
        <p class="lead text-muted mb-4">Это простой менеджер задач на Laravel</p>

        <div class="d-flex gap-3">
            <a href="https://hexlet.io"
               class="btn btn-outline-secondary"
               target="_blank">
                Нажми меня
            </a>
        </div>
    </div>

@endsection

