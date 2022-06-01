<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Takshak\Adash\Models\Faq;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pref = Faq::count() + 1;
        return [
            'question'  =>   $this->faker->realText(rand(50, 150)),
            'pref'      =>   $pref,
            'answer'    =>   $this->faker->realText(rand(200, 500)),
            'status'    =>   true,
        ];
    }
}
