<nav class="bg-white border-gray-200 py-2.5 shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4">
        <!-- Логотип -->
        <a href="{{ route('home') }}" class="flex items-center">
            <span class="self-center text-xl font-semibold whitespace-nowrap">
                {{ __('app.task_manager') }}
            </span>
        </a>

        <!-- Кнопка-бургер -->
        <button id="menu-toggle" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none"
                aria-controls="mobile-menu" aria-expanded="false">
            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Меню -->
        <div class="hidden w-full lg:flex lg:w-auto" id="mobile-menu">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                <li>
                    <a href="{{ route('tasks.index') }}"
                       class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                        {{ __('app.tasks') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('task_statuses.index') }}"
                       class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                        {{ __('app.statuses') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('labels.index') }}"
                       class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                        {{ __('app.tags') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- Кнопки входа / выхода -->
        <div class="hidden lg:flex items-center space-x-2">
            @auth
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('app.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('app.login') }}
                </a>
                <a href="{{ route('register') }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    {{ __('app.registration') }}
                </a>
            @endauth
        </div>
    </div>
</nav>
