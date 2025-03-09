@extends('layouts.app')

@section('content')
<div class="container py-12">
    <h1 class="text-2xl font-semibold mb-4">Edit Profile</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="p-2 border rounded w-full" value="{{ old('name', Auth::user()->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="p-2 border rounded w-full" value="{{ old('email', Auth::user()->email) }}" required>
        </div>

        <div class="mb-4">
            <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" class="p-2 border rounded w-full">
            @if (Auth::user()->profile_picture)
                <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="Profile Picture" class="mt-2 w-32 h-32 rounded-full">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
