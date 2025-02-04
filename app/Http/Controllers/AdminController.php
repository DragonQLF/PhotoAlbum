<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function albums(Request $request)
    {
    $query = Album::with(['user', 'photos' => function($query) {
        $query->withTrashed()->orderBy('created_at', 'desc'); // Ensure correct column
    }])
    ->withTrashed()
    ->withCount(['photos' => function($q) {
        $q->withoutTrashed(); // Count only non-deleted photos
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
}