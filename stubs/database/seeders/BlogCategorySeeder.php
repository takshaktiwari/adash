<?php

namespace Database\Seeders;

use App\Models\Blog\BlogCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Takshak\Adash\Traits\ImageTrait;

class BlogCategorySeeder extends Seeder
{
    use ImageTrait;
    public function run(Faker $faker)
    {
        \Storage::deleteDirectory('blog_categories');
        for ($i=0; $i < 10; $i++) { 
            $category = new BlogCategory;
            $category->name =   $faker->company;
            $category->slug =   \Str::of($category->name)->slug('-');
            $category->blog_category_id  =   ($i > 6) ? BlogCategory::inRandomOrder()->first()?->id : null;

            $fileName = \Str::of(microtime())->slug('-').'.jpg';
            $category->image_sm =   'blog_categories/sm/'.$fileName;
            $category->image_md =   'blog_categories/md/'.$fileName;
            $category->image_lg =   'blog_categories/'.$fileName;

            $this->initImg('https://picsum.photos/800/500')
            ->makeCopy($category->image_lg)
            ->makeCopy($category->image_md, 400)
            ->makeCopy($category->image_sm, 200);

            $category->status   =   ($i % 5 == 0) ? false : true;
            $category->featured =   ($i % 4 == 0) ? false : true;
            $category->meta_title   =   $faker->realText(rand(100, 250), 2);
            $category->meta_keywords    =   $faker->realText(rand(200, 300), 2);
            $category->meta_description =   $faker->realText(rand(200, 350), 2);

            $category->save();
        }
    }
}
