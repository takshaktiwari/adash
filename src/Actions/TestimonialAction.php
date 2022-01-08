<?php

namespace Takshak\Adash\Actions;

use Takshak\Adash\Traits\ImageTrait;
use Str;

class TestimonialAction
{
	use ImageTrait;

	public function save($request, $testimonial)
	{
		if ($request->file('avatar')) {
		    $testimonial->avatar    = 'testimonials/'.\Str::of(microtime())->slug('-').'.';
		    $testimonial->avatar    .= $request->file('avatar')->extension();
		    $this->initImg($request->file('avatar'))
		        ->resizeFit(300, 300)
		        ->inCanvas('#fff')
		        ->storeImg($testimonial->avatar);
		}
		
		$testimonial->title     = $request->post('title');
		$testimonial->subtitle  = $request->post('subtitle');
		$testimonial->rating    = $request->post('rating');
		$testimonial->content   = $request->post('content');
		$testimonial->save();

		return $testimonial;
	}
}