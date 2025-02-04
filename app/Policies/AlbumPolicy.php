<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;

class AlbumPolicy
{
    /**
     * Determine whether the user can view any albums.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view a specific album.
     */
    public function view(User $user, Album $album): bool
    {
        return $user->isAdmin() || $album->user_id === $user->id;
    }

    /**
     * Determine whether the user can manage an album (update or delete).
     */
    public function manage(User $user, Album $album): bool
    {
        return $user->isAdmin() || $album->user_id === $user->id;
    }

    /**
     * Determine whether the user can create a new album.
     */
    public function create(User $user): bool
    {
        return true; // Todos os utilizadores autenticados podem criar álbuns
    }

    /**
     * Determine whether the user can update the album.
     */
    public function update(User $user, Album $album): bool
    {
        return $user->isAdmin() || $album->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the album.
     */
    public function delete(User $user, Album $album): bool
    {
        return $user->isAdmin() || $album->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the album.
     */
    public function restore(User $user, Album $album): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the album.
     */
    public function forceDelete(User $user, Album $album): bool
    {
        return $user->isAdmin();
    }
}
