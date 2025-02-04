<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::paginate(10); // Optionally add pagination
        return view('albums.index', compact('albums'));
    }

    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    public function create()
    {
        // Display the form to create a new album
        return view('albums.create');
    }

    public function store(Request $request)
    {
        // Validate and store the new album
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $album = new Album();
        $album->title = $validated['title'];
        $album->description = $validated['description'];
        $album->user_id = auth()->id(); // Albums are tied to a user
        $album->save();

        return redirect()->route('albums.index')->with('success', 'Album created successfully');
    }

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        // Validate and update the album
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $album->title = $validated['title'];
        $album->description = $validated['description'];
        $album->save();

        return redirect()->route('albums.index')->with('success', 'Album updated successfully');
    }

    public function destroy(Album $album)
{
    

    $album->delete();

    return redirect()->route('albums.index')->with('success', 'Album deleted successfully.');
}


    public function share(Album $album)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('albums.share', compact('album', 'users'));
    }

    public function processShare(Request $request, Album $album)
    {
        // Sync the shared users with the album
        $album->sharedWith()->sync($request->users);
        return redirect()->route('albums.show', $album)->with('success', 'Album shared successfully');
    }
}
