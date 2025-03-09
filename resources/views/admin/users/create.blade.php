@extends('layouts.app')

@section('content')
<div class="container py-12">
    <h1 class="text-2xl font-semibold mb-4">Create User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="p-2 border rounded w-full" value="{{ old('name') }}" required>
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="p-2 border rounded w-full" value="{{ old('email') }}" required>
            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="p-2 border rounded w-full" required>
            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 border rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="p-2 border rounded w-full" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection
