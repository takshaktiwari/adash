<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Takshak\Adash\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        Storage::disk('public')->deleteDirectory('testimonials');
        Testimonial::truncate();
        Testimonial::factory()->count(10)->create();
    }
}
