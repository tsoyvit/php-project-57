
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ route('home') }}">{{ __('app.task_manager') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('app.tasks') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('task_statuses.index') }}">{{ __('app.statuses') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('app.tags') }}</a>
                </li>
            </ul>

            <div class="d-flex">
                @auth
                    {{ html()->form('POST', route('logout'))->open() }}
                    {{ html()->submit(__('app.logout'))->class('btn btn-primary') }}
                    {{ html()->form()->close() }}
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">{{ __('app.login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">{{ __('app.register') }}</a>
                @endauth
            </div>

        </div>
    </div>
</nav>

