@extends('layouts.app')

@section('content')
<div class="container py-12">
    <h1 class="text-2xl font-semibold mb-4">Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_admin" class="form-checkbox" {{ $user->is_admin ? 'checked' : '' }}>
                <span class="ml-2">Grant Admin Rights</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
