@extends('layouts.app')

@section('content')
<div class="container py-12">
    <h3 class="text-2xl font-semibold mb-4">Public Albums</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($publicAlbums as $album)
            <div class="border rounded-lg p-4">
                <h3 class="text-xl font-bold">{{ $album->title }}</h3>
                <p class="text-gray-600">{{ $album->description }}</p>
                <p class="text-gray-500 text-sm">Added by: {{ $album->user->name }}</p>
                <p class="text-gray-500 text-sm">Visibility: Public</p>
                <p class="text-gray-500 text-sm">Created on: {{ $album->created_at->format('F d, Y') }}</p>
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
@endsection