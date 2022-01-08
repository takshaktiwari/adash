<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use App\Models\Role;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Takshak\Adash\Actions\TestimonialAction;

trait TestimonialTrait {

	public function index(Request $request)
	{
		$this->authorize('testimonials_access');
	    $testimonials = Testimonial::latest()->get();
	    return view('admin.testimonials.index', compact('testimonials'));
	}

	public function create()
	{
		$this->authorize('testimonials_create');
	    return view('admin.testimonials.create');
	}

	public function store(Request $request, TestimonialAction $action)
	{
		$this->authorize('testimonials_create');
	    $request->validate([
	        'avatar'    =>  'nullable|image',
	        'title'     =>  'required|max:200',
	        'subtitle'  =>  'nullable|max:255',
	        'rating'    =>  'nullable|numeric|between:1,5',
	        'content'   =>  'required',
	    ]);

	    $testimonial = new Testimonial;
	    $testimonial = $action->save($request, $testimonial);

	    return redirect()->route('admin.testimonials.index')->withSuccess('SUCCESS !! New testimonial is successfully added.');
	}

	public function edit(Testimonial $testimonial)
	{
		$this->authorize('testimonials_update');
	    return view('admin.testimonials.edit', compact('testimonial'));
	}

	public function update(Request $request, Testimonial $testimonial, TestimonialAction $action)
	{
		$this->authorize('testimonials_update');
	    $request->validate([
	        'avatar'    =>  'nullable|image',
	        'title'     =>  'required|max:200',
	        'subtitle'  =>  'nullable|max:255',
	        'rating'    =>  'nullable|numeric|between:1,5',
	        'content'   =>  'required',
	    ]);

	    $testimonial = $action->save($request, $testimonial);
	    return redirect()->route('admin.testimonials.index')->withSuccess('SUCCESS !! Testimonial is successfully updated.');
	}

	public function destroy(Testimonial $testimonial)
	{
		$this->authorize('testimonials_delete');
	    \Storage::delete([$testimonial->avatar]);
	    $testimonial->delete();

	    return redirect()->route('admin.testimonials.index')->withSuccess('SUCCESS !! Testimonial is not successfully created.');
	}
	
}