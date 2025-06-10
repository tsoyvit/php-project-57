
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ route('home') }}">{{ __('app.task_manager') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tasks.index') }}">Задачи</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('task_statuses.index') }}">Статусы</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('labels.index') }}">Метки</a>
                </li>
            </ul>

            <div class="d-flex gap-2">
                @auth
                    {{ html()->form('POST', route('logout'))->open() }}
                    {{ html()->submit('Выйти')->class('btn btn-primary') }}
                    {{ html()->form()->close() }}
                @else
                    {{ html()->form('GET', route('login'))->open() }}
                    {{ html()->submit('Войти')->class('btn btn-primary') }}
                    {{ html()->form()->close() }}

                    {{ html()->form('GET', route('register'))->open() }}
                    {{ html()->submit('Зарегистрировать')->class('btn btn-primary') }}
                    {{ html()->form()->close() }}
                @endauth
            </div>

        </div>
    </div>
</nav>

