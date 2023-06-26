<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Query;
use Faker\Generator as Faker;

class QuerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i=0; $i < 100; $i++) {
            $others = [];
            for ($j=0; $j < rand(0, 6); $j++) {
                $others[strtolower($faker->word())] = $faker->sentence(rand(2, 4));
            }
            Query::create([
                'title' => $faker->word(),
                'name' => $faker->name(),
                'email' => $faker->email(),
                'mobile' => rand(1000000000, 9999999999),
                'subject' => $faker->sentence(rand(2, 4)),
                'origin' => $faker->url(),
                'content' => $faker->realText(rand(50, 250)),
                'others' => $others,
            ]);
        }
    }
}
