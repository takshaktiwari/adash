<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'              => 'Admin',
                'mobile'            => '7079582411',
                'email_verified_at' => now(),
                'password'          => 'password',
            ]
        );

        $userRole = Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->sync([$userRole->id]);

        User::factory(10)->create();
    }
}
