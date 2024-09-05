<?php

namespace App\Policies\Admin;

use App\Models\Code;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the code can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list codes');
    }

    /**
     * Determine whether the code can view the model.
     */
    public function view(User $user, Code $model): bool
    {
        return $user->hasPermissionTo('view codes');
    }

    /**
     * Determine whether the code can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create codes');
    }

    /**
     * Determine whether the code can update the model.
     */
    public function update(User $user, Code $model): bool
    {
        return $user->hasPermissionTo('update codes');
    }

    /**
     * Determine whether the code can delete the model.
     */
    public function delete(User $user, Code $model): bool
    {
        return $user->hasPermissionTo('delete codes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete codes');
    }

    /**
     * Determine whether the code can restore the model.
     */
    public function restore(User $user, Code $model): bool
    {
        return false;
    }

    /**
     * Determine whether the code can permanently delete the model.
     */
    public function forceDelete(User $user, Code $model): bool
    {
        return false;
    }
}
