<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = [
            'user_id' => (string) Str::uuid(),
            'user_name' => 'Super Admin',
            'user_email' => 'super@admin.aset',
            'user_password' => bcrypt(123456),
            'user_status' => 1
        ];

        $user = User::updateOrCreate(['user_email' => $user['user_email']],$user);
        $roleName = 'Super Admin';
        $role = Role::updateOrCreate(['name' => $roleName], ['name' => $roleName]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
