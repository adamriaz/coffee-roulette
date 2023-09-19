<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ config('app.name') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (!is_null($user))
                        <div class="text-2xl">Your next meeting</div>
                        <h4 class="text-lg mt-3"><i class="fa-solid fa-user"></i> {{ $user->name }}</h4>
                        <h5 class="text-lg"><i class="fa-regular fa-envelope"></i> {{ $user->email }}</h5>
                        <h5 class="text-lg"><i class="fa-solid fa-sitemap"></i> {{ $user->organisation }}</h5>
                        @if (!is_null($meeting))
                            <h5 class="text-lg"><i class="fa-solid fa-calendar-check"></i>
                                {{ date('D, d M Y H:i:s', strtotime($meeting->meeting_date)) }}</h5>
                        @endif
                    @else
                        <div class="text-xl">There are no users available to pair at the moment. Please check back later.</div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
