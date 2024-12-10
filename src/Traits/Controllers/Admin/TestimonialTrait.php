<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Takshak\Adash\Actions\TestimonialAction;
use Takshak\Adash\Models\Testimonial;

trait TestimonialTrait
{
    use AuthorizesRequests;
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

        return to_route('admin.testimonials.index')->withSuccess('SUCCESS !! New testimonial is successfully added.');
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
        return to_route('admin.testimonials.index')->withSuccess('SUCCESS !! Testimonial is successfully updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->authorize('testimonials_delete');
        if ($testimonial->avatar) {
            Storage::delete([$testimonial->avatar]);
        }
        $testimonial->delete();

        return to_route('admin.testimonials.index')->withSuccess('SUCCESS !! Testimonial is not successfully created.');
    }
}
