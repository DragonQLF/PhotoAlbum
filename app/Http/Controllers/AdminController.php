<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function albums(Request $request)
    {
        
        $query = Album::with(['user', 'photos' => function($query) {
            $query->withTrashed()->orderBy('created_at', 'desc'); // Ensure correct column
        }])
        ->withTrashed()
        ->withCount(['photos' => function($q) {
            $q->withTrashed(); // Count all photos including deleted ones
        }])
        ->latest();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%");
                  });
            });
        }

        $albums = $query->paginate(10);

        return view('admin.albums', compact('albums'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function updateRole(User $user, Request $request)
    {
        $request->validate(['role' => 'required|in:user,admin']);
        $user->update(['role' => $request->role]);
        return redirect()->route('admin.users')->with('success', 'Role updated');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

}