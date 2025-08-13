<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'status' => 1,
            ],
            [
                'name' => 'Company Admin',
                'slug' => 'company-admin',
                'status' => 1,
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'status' => 1,
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'status' => 1,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
