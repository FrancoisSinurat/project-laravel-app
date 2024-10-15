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
        $users = [
            [
                'user_name' => 'Super Admin',
                'user_fullname' => 'Super Admin',
                'user_email' => 'super@admin.aset',
                'user_password' => bcrypt(123456),
                'user_status' => 1,
                'role' => 'Super Admin'
            ],
            [
                'user_name' => 'Pegawai',
                'user_fullname' => 'pegawai',
                'user_email' => 'lorem@pegawai.com',
                'user_password' => bcrypt(123456),
                'user_status' => 1,
                'role' => 'pegawai'
            ],
            [
                'user_name' => 'pejabat',
                'user_fullname' => 'pejabat',
                'user_email' => 'lorem@pejabat.com',
                'user_password' => bcrypt(123456),
                'user_status' => 1,
                'role' => 'Pejabat Aset'
            ],
            [
                'user_name' => 'operator',
                'user_fullname' => 'operator',
                'user_email' => 'lorem@op.com',
                'user_password' => bcrypt(123456),
                'user_status' => 1,
                'role' => 'operator'
            ],
            
            // Tambahkan pengguna lainnya di sini
        ];

        // Loop melalui setiap pengguna dan buat pengguna serta role-nya
        foreach ($users as $userData) {
            // Membuat atau memperbarui pengguna berdasarkan email
            $user = User::updateOrCreate(['user_email' => $userData['user_email']], [
                'user_name' => $userData['user_name'],
                'user_fullname' => $userData['user_fullname'],
                'user_email' => $userData['user_email'],
                'user_password' => $userData['user_password'],
                'user_status' => $userData['user_status'],
            ]);

            // Membuat atau memperbarui role
            $roleName = $userData['role'];
            $role = Role::updateOrCreate(['name' => $roleName], ['name' => $roleName]);

            // Mendapatkan semua izin dan menambahkan ke role
            $permissions = Permission::pluck('id', 'id')->all();
            $role->syncPermissions($permissions);

            // Menetapkan role ke pengguna
            $user->assignRole([$role->id]);
        }
    }
}
