<?php

namespace Takshak\Adash\Actions;

use Str;
use Takshak\Imager\Facades\Imager;

class TestimonialAction
{
	public function save($request, $testimonial)
	{
		if ($request->file('avatar')) {
		    $testimonial->avatar    = 'testimonials/'.\Str::of(microtime())->slug('-').'.';
		    $testimonial->avatar    .= $request->file('avatar')->extension();

		    Imager::init($request->file('avatar'))
		        ->resizeFit(300, 300)
		        ->inCanvas('#fff')
		        ->save(\Storage::disk('public')->path($testimonial->avatar));
		}
		
		$testimonial->title     = $request->post('title');
		$testimonial->subtitle  = $request->post('subtitle');
		$testimonial->rating    = $request->post('rating');
		$testimonial->content   = $request->post('content');
		$testimonial->save();

		return $testimonial;
	}
}