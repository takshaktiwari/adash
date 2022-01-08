<?php

namespace Takshak\Adash\Actions;

use Takshak\Adash\Traits\ImageTrait;
use Str;

class PageAction
{
	use ImageTrait;

	public function save($request, $page)
	{
		$page->title    =   $request->post('title');
		$page->slug     =   \Str::of($page->title)->slug('-');
		$page->content  =   $request->post('content');
		$page->status   =   $request->post('status');

		if ($request->file('thumbnail')) {
		    $page->banner   =   'pages/'.$page->slug.'.';
		    $page->banner   .=  $request->file('thumbnail')->extension();

		    $this->initImg($request->file('thumbnail'))
		        ->resizeFit(900, 500)
		        ->inCanvas('#fff')
		        ->storeImg($page->banner);
		}

		$page->save();

		return $page;
	}
}