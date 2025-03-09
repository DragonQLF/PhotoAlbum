<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AlbumController::class, 'publicAlbums'])->name('dashboard');
Route::get('/public-albums', [AlbumController::class, 'publicAlbums'])->name('albums.public');

Route::middleware(['auth', 'verified'])->group(function () {
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
    // Admin routes
    Route::get('/admin/albums', [AdminController::class, 'albums'])->name('admin.albums');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::patch('/admin/users/{user}/update-role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroyUser');
});

require __DIR__.'/auth.php';