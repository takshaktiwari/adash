<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Takshak\Imager\Facades\Picsum;
use Illuminate\Support\Str;
use Takshak\Adash\Models\Page;

class PageFactory extends Factory
{
    protected $model = Page::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title      = $this->faker->realText(rand(30, 60), 2);
        $slug       = Str::of($title)->slug('-');
        $banner     =   'pages/' . $slug . '.jpg';
        Picsum::dimensions(800, 500)->save(Storage::disk('public')->path($banner))->destroy();

        return [
            'title' =>  $title,
            'slug'  =>  $slug,
            'banner'    =>  $banner,
            'content'   =>  $this->faker->realText(rand(1000, 2500), 2),
            'status'    =>  true,
        ];
    }
}
