@vite(['resources/css/app.css', 'resources/js/app.js'])
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<div id="app">
    <header class="fixed w-full">
        <nav class="bg-white border-gray-200 py-2.5 shadow-md">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                <a href="https://php-task-manager-ru.hexlet.app" class="flex items-center">
                    <span class="self-center text-xl font-semibold whitespace-nowrap">Менеджер задач</span>                </a>

                <div class="flex items-center lg:order-2">
                    <a href="https://php-task-manager-ru.hexlet.app/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Вход
                    </a>
                    <a href="https://php-task-manager-ru.hexlet.app/register" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Регистрация
                    </a>
                </div>

                <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="https://php-task-manager-ru.hexlet.app/tasks" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Задачи                                </a>
                        </li>
                        <li>
                            <a href="https://php-task-manager-ru.hexlet.app/task_statuses" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Статусы                                </a>
                        </li>
                        <li>
                            <a href="https://php-task-manager-ru.hexlet.app/labels" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Метки                                </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">Статусы</h1>

                <div>
                </div>

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Дата создания</th>
                    </tr>
                    </thead>
                    <tbody><tr class="border-b border-dashed border-gray-200">
                        <td>1</td>
                        <td>новая</td>
                        <td>31.05.2025</td>
                        <td>
                        </td>
                    </tr>
                    <tr class="border-b border-dashed border-gray-200">
                        <td>2</td>
                        <td>завершена</td>
                        <td>31.05.2025</td>
                        <td>
                        </td>
                    </tr>
                    <tr class="border-b border-dashed border-gray-200">
                        <td>3</td>
                        <td>выполняется</td>
                        <td>31.05.2025</td>
                        <td>
                        </td>
                    </tr>
                    <tr class="border-b border-dashed border-gray-200">
                        <td>4</td>
                        <td>в архиве</td>
                        <td>31.05.2025</td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </section>
</div>
