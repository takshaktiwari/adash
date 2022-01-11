<?php

namespace Database\Seeders;

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Takshak\Adash\Traits\ImageTrait;

class BlogPostSeeder extends Seeder
{
    use ImageTrait;
    public function run(Faker $faker)
    {
        \Storage::deleteDirectory('blog_posts');
        $users = User::pluck('id');
        $postCategories = BlogCategory::pluck('id');

        for ($i=0; $i < 60; $i++) { 
            $post = new BlogPost;

            $post->title    = $faker->realText(rand(100, 200), 2);
            $post->slug = \Str::of($post->title)->slug('-');

            $fileName = \Str::of(microtime())->slug('-').'.jpg';
            $post->image_sm = 'blog_posts/sm/'.$fileName;
            $post->image_md = 'blog_posts/md/'.$fileName;
            $post->image_lg = 'blog_posts/'.$fileName;

            $this->initImg('https://picsum.photos/800/500')
            ->makeCopy($post->image_lg)
            ->makeCopy($post->image_md, 400)
            ->makeCopy($post->image_sm, 200);

            $post->status   = ($i % 5 == 0) ? false : true;
            $post->featured = ($i % 4 == 0) ? false : true;
            $post->commentable  = rand(0, 1);

            $post->content  = $faker->realText(rand(500, 2000), 2);
            $post->m_title  = $faker->realText(rand(100, 200), 2);
            $post->m_keywords   = $faker->realText(rand(100, 250), 2);
            $post->m_description    = $faker->realText(rand(100, 300), 2);

            $post->user_id  = $users->shuffle()->first();
            $post->save();

            $post->categories()->sync(
                $postCategories->shuffle()->take(rand(2, 5))->toArray()
            );
        }
    }
}
