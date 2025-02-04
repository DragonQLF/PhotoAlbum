@extends('layouts.app')

@section('content')
<div class="container py-12">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">My Albums</h1>
        <a href="{{ route('albums.create') }}" 
           class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
            Create New Album
        </a>
    </div>

    <!-- List Albums -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($albums as $album)
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
        {{ $albums->links() }}
    </div>
</div>
@endsection