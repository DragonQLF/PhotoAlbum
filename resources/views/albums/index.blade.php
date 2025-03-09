@extends('layouts.app')

@section('content')
    <div class="container py-12">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold">My Albums</h1>
            <button onclick="openCreateModal()" 
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Create New Album
            </button>
        </div>

        <!-- List Albums -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($albums as $album)
                <div class="border rounded-lg p-4 relative">
                    <h3 class="text-xl font-bold">{{ $album->title }}</h3>
                    <p class="text-gray-600">{{ $album->description }}</p>
                    @if ($album->is_public)
                        <p class="text-gray-500 text-sm">Added by: {{ $album->user->name }}</p>
                        <p class="text-gray-500 text-sm">Visibility: Public</p>
                    @else
                        <p class="text-gray-500 text-sm">Visibility: Private</p>
                    @endif
                    <p class="text-gray-500 text-sm">Created on: {{ $album->created_at->format('M d, Y') }}</p>
                    <a href="{{ route('albums.show', $album) }}" 
                       class="text-blue-500 mt-2 inline-block hover:text-blue-700">
                        View Album
                    </a>
                    <button class="absolute top-2 right-2" onclick="openEditModal({{ $album->id }})">
                        <i class="fas fa-wrench"></i>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $albums->links() }}
        </div>
    </div>

    <!-- Hidden Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-10 rounded-lg w-1/2">
            <h2 class="text-2xl font-semibold mb-4">Edit Album</h2>
            <form id="editAlbumForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal('editModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-800 bg-opacity-90 flex items-center justify-center hidden">
        <div class="bg-white p-10 rounded-lg w-1/2">
            <h2 class="text-2xl font-semibold mb-4">Create Album</h2>
            <form method="POST" action="{{ route('albums.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-800 text-white leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-800 text-white leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Visibility
                    </label>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_public" value="1" class="form-radio" checked>
                            <span class="ml-2">Public</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="is_public" value="0" class="form-radio">
                            <span class="ml-2">Private</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal('createModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(albumId) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editAlbumForm').action = `/albums/${albumId}`;
        }

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection