<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::where('user_id', Auth::id())->paginate(10);
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
        ]);

        Album::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'is_public' => $request->is_public,
        ]);

        return redirect()->route('albums.index')->with('success', 'Album created successfully.');
    }

    public function show($id)
    {
        $album = Album::with(['photos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('albums.show', compact('album'));
    }

    public function destroy(Album $album)
    {
        if ($album->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album deleted successfully.');
    }

    public function publicAlbums()
    {
        $publicAlbums = Album::where('is_public', true)->paginate(10);
        return view('albums.public', compact('publicAlbums'));
    }
}
