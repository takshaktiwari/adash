<?php

namespace Takshak\Adash\Actions;

use Str;
use Takshak\Imager\Facades\Imager;

class PageAction
{
	public function save($request, $page)
	{
		$page->title    =   $request->post('title');
		$page->slug     =   \Str::of($page->title)->slug('-');
		$page->content  =   $request->post('content');
		$page->status   =   $request->post('status');

		if ($request->file('thumbnail')) {
		    $page->banner   =   'pages/'.$page->slug.'.';
		    $page->banner   .=  $request->file('thumbnail')->extension();

		    Imager::init($request->file('thumbnail'))
		        ->resizeFit(900, 500)
		        ->inCanvas('#fff')
		        ->save(\Storage::disk('public')->path($page->banner));
		}

		$page->save();

		return $page;
	}
}