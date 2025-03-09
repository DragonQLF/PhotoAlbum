@extends('layouts.app')

@section('content')
<div class="container py-12">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Users</h1>
        <!-- Button to open the modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
            Open Create User Form
        </button>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-white-700">Name</label>
                            <input type="text" name="name" id="name" class="p-2 border rounded w-full bg-transparent" value="{{ old('name') }}" required>
                            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-white-700">Email</label>
                            <input type="email" name="email" id="email" class="p-2 border rounded w-full bg-transparent" value="{{ old('email') }}" required>
                            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-white-700">Password</label>
                            <input type="password" name="password" id="password" class="p-2 border rounded w-full bg-transparent" required>
                            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-white-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 border rounded w-full bg-transparent" required>
                            @error('password_confirmation') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-white-700">Role</label>
                            <select name="role" id="role" class="p-2 border rounded w-full bg-transparent" required>
                                <option value="admin" style="background-color: transparent;">Admin</option>
                                <option value="user" style="background-color: transparent;" selected>User</option>
                            </select>
                            @error('role') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-transparent">
                <tr>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3  px-4 text-left">Role</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @foreach($users as $user)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="role" 
                                        class="border border-gray-300   bg-white text-white-700 " 
                                        onchange="this.form.submit()">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-3 px-4">
                            <form action="{{ route('admin.users.destroyUser', $user) }}" method="POST" onsubmit="return confi   rm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<!-- Include Bootstrap JS for modal functionality -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endsection
