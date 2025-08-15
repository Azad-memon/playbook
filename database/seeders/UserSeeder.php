<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModelUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        ModelUsers::create([
            'name' => 'Super Admin',
            'role_id' => $superAdminRole->id,
            "phone_number" => 11111111,
            'email' => 'superadmin@yopmail.com',
            'password' => Hash::make('password'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);



    }
}
