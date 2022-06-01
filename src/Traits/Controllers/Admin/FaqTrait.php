<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Takshak\Adash\Actions\FaqAction;
use Illuminate\Http\Request;
use Takshak\Adash\Models\Faq;

trait FaqTrait
{
    public function index(Request $request)
    {
        $this->authorize('faqs_access');
        $query = Faq::select('id', 'question', 'pref', 'status', 'created_at', 'updated_at');
        if ($request->get('search')) {
            $query->where('question', 'LIKE', '%' . $request->get('search') . '%');
            $query->orWhere('pref', 'LIKE', '%' . $request->get('search') . '%');
            $query->orWhere('answer', 'LIKE', '%' . $request->get('search') . '%');
        }
        if ($request->get('status') != null) {
            $query->where('status', $request->get('status'));
        }
        $faqs = $query->orderBy('pref')->paginate(50);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $this->authorize('faqs_create');
        return view('admin.faqs.create');
    }

    public function store(Request $request, FaqAction $action)
    {
        $this->authorize('faqs_create');
        $request->validate([
            'question'  =>  'required|unique:faqs,question',
            'pref'  =>  'nullable|numeric',
            'status'    =>  'nullable|boolean',
            'answer'   =>  'required'
        ]);

        $faq = new Faq;
        $faq = $action->save($request, $faq);

        return to_route('admin.faqs.index')->withSuccess('SUCCESS !! New FAQ has been added');
    }

    public function show(Faq $faq)
    {
        $this->authorize('faqs_show');
        return view('admin.faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        $this->authorize('faqs_update');
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq, FaqAction $action)
    {
        $this->authorize('faqs_update');
        $request->validate([
            'question'  =>  'required|unique:faqs,question,' . $faq->id,
            'pref'  =>  'nullable|numeric',
            'status'    =>  'nullable|boolean',
            'answer'   =>  'required'
        ]);

        $faq = $action->save($request, $faq);
        return to_route('admin.faqs.index')->withSuccess('SUCCESS !! FAQ has been updated');
    }

    public function destroy(Faq $faq)
    {
        $this->authorize('faqs_delete');
        $faq->delete();
        return to_route('admin.faqs.index')->withSuccess('SUCCESS !! Faq has been successfully deleted');
    }
}
