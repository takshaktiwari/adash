<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
        Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'author']);
        Role::firstOrCreate(['name' => 'executive']);
        Role::firstOrCreate(['name' => 'viewer']);
    }
}
