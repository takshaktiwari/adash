<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Takshak\Adash\Traits\ImageTrait;

class TestimonialSeeder extends Seeder
{
    use ImageTrait;
    public function run(Faker $faker)
    {
        \Storage::deleteDirectory('testimonials');
        Testimonial::truncate();

        for ($i=0; $i < 8; $i++) { 
            $testimonial = new Testimonial;
            $testimonial->avatar    = 'testimonials/'.\Str::of(microtime())->slug('-').'.jpg';
            $testimonial->title     =   $faker->realText(rand(10, 20), 2);
            $testimonial->subtitle  =   $faker->realText(rand(15, 30), 2);
            $testimonial->rating    =   rand(1, 5);
            $testimonial->content   =   $faker->realText(rand(100, 300), 2);

            $this->initImg('https://picsum.photos/300/300')->storeImg($testimonial->avatar);
            $testimonial->save();
        }
    }
}
