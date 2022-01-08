<?php

namespace Takshak\Adash\Actions\Blog;

use Takshak\Adash\Traits\ImageTrait;
use Str;

class BlogPostAction
{
	use ImageTrait;
	public function save($request, $post)
	{
		$post->title    = $request->post('title');
		$post->slug     = Str::of($post->title.'-'.rand(1, 99))->slug('-');
		$post->status   = $request->post('status');
		$post->featured = $request->post('featured');
		$post->commentable  = $request->post('commentable');
		$post->content      = $request->post('content');
		$post->m_title      = $request->post('m_title');
		$post->m_keywords   = $request->post('m_keywords');
		$post->m_description    = $request->post('m_description');
		$post->user_id 			= auth()->id();

		if ($request->file('thumbnail')){
		    $imageName = $category->slug.'.'.$request->file('thumbnail')->extension();
		    $post->image_sm = 'blog_posts/sm/'.$imageName;
		    $post->image_md = 'blog_posts/md/'.$imageName;
		    $post->image_lg = 'blog_posts/'.$imageName;

		    $this->initImg($request->file('thumbnail'))
		        ->resizeFit(800, 500)
		        ->makeCopy($category->image_lg)
		        ->makeCopy($category->image_md, 400)
		        ->makeCopy($category->image_sm, 200);
		}
		$post->save();

		return $post;
	}
}