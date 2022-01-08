<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Takshak\Adash\Actions\PageAction;
use App\Models\Page;
use Takshak\Adash\Traits\ImageTrait;
use Illuminate\Http\Request;

trait PageTrait {

	use ImageTrait;
	public function index()
	{
		$this->authorize('pages_access');
	    $pages = Page::select('id', 'title', 'slug', 'status', 'banner', 'created_at')->orderBy('title')->get();
	    return view('admin.pages.index', compact('pages'));
	}

	public function create()
	{
		$this->authorize('pages_create');
	    return view('admin.pages.create');
	}

	public function store(Request $request, PageAction $action)
	{
		$this->authorize('pages_create');
	    $request->validate([
	        'title' =>  'required|unique:pages,title',
	        'status'    =>  'nullable|boolean',
	        'content'   =>  'required'
	    ]);

	    $page = new Page;
	    $page = $action->save($request, $page);
	    return redirect()->route('admin.pages.index')->withSuccess('SUCCESS !! New page has been successfully created');
	}

	public function edit(Page $page)
	{
		$this->authorize('pages_update');
	    return view('admin.pages.edit', compact('page'));
	}

	public function update(Request $request, Page $page, PageAction $action)
	{
		$this->authorize('pages_update');
	    $request->validate([
	        'title' =>  'required|unique:pages,title,'.$page->id,
	        'status'    =>  'nullable|boolean',
	        'content'   =>  'required'
	    ]);

	    $page = $action->save($request, $page);
	    return redirect()->route('admin.pages.index')->withSuccess('SUCCESS !! New page has been successfully updated');
	}

	public function destroy(Page $page)
	{
		$this->authorize('pages_delete');
	    \Storage::delete([ $page->banner ]);
	    $page->delete();

	    return redirect()->route('admin.pages.index')->withSuccess('SUCCESS !! Page has been successfully deleted');
	}

}