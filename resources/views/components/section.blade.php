<x-div id="app">
    <section class="bg-white dark:bg-gray-900 h-screen">
        <x-div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            {{ $slot }}
        </x-div>
    </section>
</x-div>
