<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-semibold mb-4">Public Albums</h3>
                <a href="{{ route('albums.public') }}" class="text-blue-500 mb-4 inline-block">View All Public Albums</a>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($publicAlbums as $album)
                        <div class="border rounded-lg p-4">
                            <h3 class="text-xl font-bold">{{ $album->title }}</h3>
                            <p class="text-gray-600">{{ $album->description }}</p>
                            <a href="{{ route('albums.show', $album) }}" 
                               class="text-blue-500 mt-2 inline-block hover:text-blue-700">
                                View Album
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $publicAlbums->links() }}
                </div>
            </div>
        </div>
    </div>

    @guest
        <div class="fixed bottom-0 right-0 p-6">
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-blue-500 hover:text-blue-700">Register</a>
            @endif
        </div>
    @endguest
</x-app-layout>
