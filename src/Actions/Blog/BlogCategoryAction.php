<?php

namespace Takshak\Adash\Actions\Blog;

use Takshak\Adash\Traits\ImageTrait;
use Str;

class BlogCategoryAction
{
	use ImageTrait;
	public function save($request, $category)
	{
		$category->name = $request->post('name');
		$category->slug = Str::of($category->name.'-'.rand(1, 99))->slug('-');
		$category->blog_category_id = $request->post('blog_category_id');
		$category->status = $request->post('status');
		$category->featured = $request->post('featured');
		$category->meta_title = $request->post('meta_title');
		$category->meta_keywords = $request->post('meta_keywords');
		$category->meta_description = $request->post('meta_description');

		if ($request->file('thumbnail')) {
		    $imageName = $category->slug.'.'.$request->file('thumbnail')->extension();
		    $category->image_lg = 'blog_categories/'.$imageName;
		    $category->image_md = 'blog_categories/md/'.$imageName;
		    $category->image_sm = 'blog_categories/sm/'.$imageName;

		    $this->initImg($request->file('thumbnail'))
		        ->resizeFit(800, 500)
		        ->makeCopy($category->image_lg)
		        ->makeCopy($category->image_md, 400)
		        ->makeCopy($category->image_sm, 200);
		}
		$category->save();

		return $category;
	}

}