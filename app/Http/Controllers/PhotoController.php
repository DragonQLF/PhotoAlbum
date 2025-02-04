<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
class PhotoController extends Controller
{
    use SoftDeletes;
    /**
     * Store newly uploaded photos
     */
    public function store(Request $request, Album $album)
    {

    $request->validate([
        'photos' => 'required|array',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        'descriptions' => 'nullable|array'
    ]);

    foreach ($request->file('photos') as $index => $photo) {
        $path = $photo->store('photos', 'public');

        $album->photos()->create([
            'path' => $path,
            'description' => $request->descriptions[$index] ?? ''
        ]);
    }

    return redirect()->route('albums.show', $album)->with('success', 'Photos uploaded successfully.');
    }

    public function destroy(Photo $photo)
    {

    $photo->delete();

    return back()->with('success', 'Photo moved to trash.');
    }

    public function forceDestroy($id)
    {
    $photo = Photo::withTrashed()->findOrFail($id);


    Storage::disk('public')->delete($photo->path);
    $photo->forceDelete();

    return back()->with('success', 'Photo permanently deleted.');
}

    /**
     * Update photo description
     */
    public function updateDescription(Request $request, Photo $photo)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        

        $photo->update([
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Description updated successfully!');
    }
}
  
