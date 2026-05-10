<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Query;

class QuerySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $others = [];
            for ($j = 0; $j < rand(0, 6); $j++) {
                $others[strtolower(fake()->word())] = fake()->sentence(rand(2, 4));
            }
            Query::create([
                'title'   => fake()->word(),
                'name'    => fake()->name(),
                'email'   => fake()->email(),
                'mobile'  => fake()->numerify('##########'),
                'subject' => fake()->sentence(rand(2, 4)),
                'origin'  => fake()->url(),
                'content' => fake()->realText(rand(50, 250)),
                'others'  => $others,
                'ip'      => fake()->ipv4(),
            ]);
        }
    }
}
