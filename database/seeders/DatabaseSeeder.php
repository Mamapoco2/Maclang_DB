<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Seed hospital structure first
        $this->call(HospitalStructureSeeder::class);
        $this->call(RolePermissionSeeder::class);


        // 🔹 Optional: Create test user
        $user = User::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'status' => 'active'
            ]
        );
    }
}
