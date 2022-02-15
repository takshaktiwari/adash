<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pref = \App\Models\Faq::count() + 1;
        return [
            'question'  =>   $this->faker->realText(rand(50, 150)),
            'pref'      =>   $pref,
            'answer'    =>   $this->faker->realText(rand(200, 500)),
            'status'    =>   true,
        ];
    }
}
