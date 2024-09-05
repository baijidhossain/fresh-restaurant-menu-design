<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // Create default permissions
    Permission::create(['name' => 'list codes']);
    Permission::create(['name' => 'view codes']);
    Permission::create(['name' => 'create codes']);
    Permission::create(['name' => 'update codes']);
    Permission::create(['name' => 'delete codes']);

    Permission::create(['name' => 'list restaurant_user']);
    Permission::create(['name' => 'view restaurant_user']);
    Permission::create(['name' => 'create restaurant_user']);
    Permission::create(['name' => 'update restaurant_user']);
    Permission::create(['name' => 'delete restaurant_user']);

    Permission::create(['name' => 'list SocialLinks']);
    Permission::create(['name' => 'view SocialLinks']);
    Permission::create(['name' => 'create SocialLinks']);
    Permission::create(['name' => 'update SocialLinks']);
    Permission::create(['name' => 'delete SocialLinks']);

    // Create user role and assign existing permissions
    $currentPermissions = Permission::all();
    $userRole = Role::create(['name' => 'user']);
    $userRole->givePermissionTo($currentPermissions);

    // Create admin exclusive permissions
    Permission::create(['name' => 'list roles']);
    Permission::create(['name' => 'view roles']);
    Permission::create(['name' => 'create roles']);
    Permission::create(['name' => 'update roles']);
    Permission::create(['name' => 'delete roles']);

    Permission::create(['name' => 'list permissions']);
    Permission::create(['name' => 'view permissions']);
    Permission::create(['name' => 'create permissions']);
    Permission::create(['name' => 'update permissions']);
    Permission::create(['name' => 'delete permissions']);

    Permission::create(['name' => 'list users']);
    Permission::create(['name' => 'view users']);
    Permission::create(['name' => 'create users']);
    Permission::create(['name' => 'update users']);
    Permission::create(['name' => 'delete users']);

    // Create admin role and assign all permissions
    $allPermissions = Permission::all();
    $adminRole = Role::create(['name' => 'super-admin']);
    $adminRole->givePermissionTo($allPermissions);

    $user = \App\Models\User::whereEmail('admin@admin.com')->first();

    if ($user) {
      $user->assignRole($adminRole);
    }
  }
}
