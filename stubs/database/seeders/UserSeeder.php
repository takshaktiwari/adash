<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = User::create([
        	'name'	=>	'Admin',
        	'mobile'	=>	'7079582411',
        	'email'		=>	'adash@gmail.com',
        	'email_verified_at'	=>	date('Y-m-d H:i:s'),
        	'password'			=>	\Hash::make('123456'),
        ]);
        $userRole = Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->sync([$userRole->id]);

        User::create([
        	'name'	=>	'Romeo Tr2',
        	'mobile'	=>	'9631574374',
        	'email'		=>	'silentromeo95@gmail.com',
        	'email_verified_at'	=>	date('Y-m-d H:i:s'),
        	'password'			=>	\Hash::make('123456'),
        ]);

        User::create([
        	'name'	=>	'Romeo Tr3',
        	'mobile'	=>	'7079582410',
        	'email'		=>	'silentromeo96@gmail.com',
        	'email_verified_at'	=>	date('Y-m-d H:i:s'),
        	'password'			=>	\Hash::make('123456'),
        ]);

    }

}
