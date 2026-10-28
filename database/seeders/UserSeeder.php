<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::forceCreate([
            'name'              => 'Admin AndTop',
            'email'             => 'admin@gmail.com',
            'password'          => 'password',
            'role_id'           => 1,
            'status'            => 'aktif',
            'email_verified_at' => now(),
        ]);

        User::forceCreate([
            'id'                => 2,
            'name'              => 'Customer 1',
            'email'             => 'customer1@gmail.com',
            'password'          => 'password',
            'role_id'           => 2,
            'status'            => 'aktif',
            'email_verified_at' => now(),
        ]);
    }
}
