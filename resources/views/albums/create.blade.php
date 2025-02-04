@extends('layouts.app')

@section('content')
    <div class="container py-12">
        <h2 class="text-xl mb-4">Create Album</h2>
        <form method="POST" action="{{ route('albums.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Album Title</label>
                <input type="text" name="title" class="form-input w-full bg-transparent text-black border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Album Description</label>
                <input type="text" name="description" class="form-input w-full bg-transparent text-black border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Create Album
            </button>
        </form>
    </div>
@endsection
