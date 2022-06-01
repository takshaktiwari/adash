<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'    =>    'admin']);
        Role::create(['name'    =>    'user']);

        Role::create(['name'    =>  'editor']);
        Role::create(['name'    =>  'manager']);
        Role::create(['name'    =>  'author']);
        Role::create(['name'    =>  'executive']);
        Role::create(['name'    =>  'publisher']);
        Role::create(['name'    =>  'contributor']);
        Role::create(['name'    =>  'viewer']);
        Role::create(['name'    =>  'biller']);
        Role::create(['name'    =>  'moderator']);
    }
}
