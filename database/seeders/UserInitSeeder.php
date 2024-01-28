<?php

namespace Database\Seeders;

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

        User::updateOrCreate(['user_email' => $user['user_email']],$user);
    }
}
