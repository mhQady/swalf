<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name'], 'guard_name' => 'admin'], ['model' => $perm['model']]);
        }

        $role = Role::firstOrCreate(['id' => 1, 'name' => 'Admin', 'guard_name' => 'admin']);

        $role->givePermissionTo(\Spatie\Permission\Models\Permission::all()->pluck('name'));

        $admin = Admin::firstOrCreate([
            'email' => 'superadmin@admin.com',
        ], [
            'name' => 'Super-Admin',
            'password' => 'password',
        ]);

        $admin->assignRole($role);

        $this->command->info('Default permissions added successfully.');
    }
}
