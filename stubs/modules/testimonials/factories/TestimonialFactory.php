<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Takshak\Imager\Facades\Placeholder;

class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title      = $this->faker->realText(rand(10, 20), 2);
        $avatar     = 'testimonials/'.\Str::of(microtime())->slug('-').'.jpg';
        Placeholder::dimensions(150, 150)
        ->background(rand(100, 999))
        ->text(substr($title, 0, 2), [
            'color' => '#fff',
            'size'  => 60
        ])
        ->save(\Storage::disk('public')->path($avatar))
        ->destroy();

        return [
            'title'     =>  $title,
            'subtitle'  =>  $this->faker->realText(rand(15, 30), 2),
            'avatar'    =>  $avatar,
            'rating'    =>  rand(2, 5),
            'content'   =>  $this->faker->realText(rand(100, 300), 2),
        ];
    }
}
