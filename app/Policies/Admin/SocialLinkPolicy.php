<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\SocialLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the SocialLink can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list SocialLinks');
    }

    /**
     * Determine whether the SocialLink can view the model.
     */
    public function view(User $user, SocialLink $model): bool
    {
        return $user->hasPermissionTo('view SocialLinks');
    }

    /**
     * Determine whether the SocialLink can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create SocialLinks');
    }

    /**
     * Determine whether the SocialLink can update the model.
     */
    public function update(User $user, SocialLink $model): bool
    {
        return $user->hasPermissionTo('update SocialLinks');
    }

    /**
     * Determine whether the SocialLink can delete the model.
     */
    public function delete(User $user, SocialLink $model): bool
    {
        return $user->hasPermissionTo('delete SocialLinks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete SocialLinks');
    }

    /**
     * Determine whether the SocialLink can restore the model.
     */
    public function restore(User $user, SocialLink $model): bool
    {
        return false;
    }

    /**
     * Determine whether the SocialLink can permanently delete the model.
     */
    public function forceDelete(User $user, SocialLink $model): bool
    {
        return false;
    }
}
