<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Album routes
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');

    // Photo routes
    Route::get('/albums/{album}/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('/albums/{album}/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
    Route::get('/photos/{photo}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::put('/photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
    Route::put('/photos/{photo}/description', [PhotoController::class, 'updateDescription'])->name('photos.update-description');
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::delete('/photos/{photo}/force', [PhotoController::class, 'forceDestroy'])->name('photos.force-destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/albums', [AdminController::class, 'albums'])->name('admin.albums');
    Route::get('/admin/photos', [AdminController::class, 'photos'])->name('admin.photos');
    Route::delete('/admin/photos/{photo}', [AdminController::class, 'destroyPhoto'])->name('admin.photos.destroy');
});

require __DIR__.'/auth.php';
