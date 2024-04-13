<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Services\Permissions\GeneratePermissions;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Adding default permissions...');
        GeneratePermissions::generatePermissions();

        $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);

        $role->syncPermissions(Permission::all()->pluck('name'));

        $this->command->info('Create Super Admin...');

        $admin = Admin::firstOrCreate([
            'email' => 'admin@swalf.com',
        ], [
            'name' => 'Super Admin',
            'password' => 'password'
        ]);

        $admin->assignRole($role);

        $this->command->info('Default permissions added successfully.');
    }
}
