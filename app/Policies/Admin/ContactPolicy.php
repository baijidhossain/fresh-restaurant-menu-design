<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the contact can view any models.
   */
  public function viewAny(User $user): bool
  {
    return $user->hasPermissionTo('list restaurant_user');
  }

  /**
   * Determine whether the contact can view the model.
   */
  public function view(User $user, Contact $model): bool
  {
    return $user->hasPermissionTo('view restaurant_user');
  }

  /**
   * Determine whether the contact can create models.
   */
  public function create(User $user): bool
  {
    return $user->hasPermissionTo('create restaurant_user');
  }

  /**
   * Determine whether the contact can update the model.
   */
  public function update(User $user, Contact $model): bool
  {
    return $user->hasPermissionTo('update restaurant_user');
  }

  /**
   * Determine whether the contact can delete the model.
   */
  public function delete(User $user, Contact $model): bool
  {
    return $user->hasPermissionTo('delete restaurant_user');
  }

  /**
   * Determine whether the user can delete multiple instances of the model.
   */
  public function deleteAny(User $user): bool
  {
    return $user->hasPermissionTo('delete restaurant_user');
  }

  /**
   * Determine whether the contact can restore the model.
   */
  public function restore(User $user, Contact $model): bool
  {
    return false;
  }

  /**
   * Determine whether the contact can permanently delete the model.
   */
  public function forceDelete(User $user, Contact $model): bool
  {
    return false;
  }
}
