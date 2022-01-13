<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Takshak\Imager\Facades\Avatar;

class TestimonialSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        \Storage::disk('public')->deleteDirectory('testimonials');
        Testimonial::truncate();

        for ($i=0; $i < 8; $i++) { 
            $testimonial = new Testimonial;
            $testimonial->avatar    = 'testimonials/'.\Str::of(microtime())->slug('-').'.jpg';
            $testimonial->title     =   $faker->realText(rand(10, 20), 2);
            $testimonial->subtitle  =   $faker->realText(rand(15, 30), 2);
            $testimonial->rating    =   rand(1, 5);
            $testimonial->content   =   $faker->realText(rand(100, 300), 2);

            Avatar::name($testimonial->title)->background(rand(100, 999))->color('fff')->save(\Storage::disk('public')->path($testimonial->avatar));

            $testimonial->save();
        }
    }
}
