<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();

        Role::create([
            'id' => 1,
            'name' => 'Admin',
        ]);

        Role::create([
            'id' => 2,
            'name' => 'User',
        ]);
    }
}
