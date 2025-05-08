<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use App\DataTables\QueriesDataTable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Takshak\Adash\Models\Query;

trait QueryTrait
{
    use AuthorizesRequests;
    public function index(QueriesDataTable $dataTable)
    {
        return $dataTable->render('admin.queries.index');
    }

    public function show(Query $query)
    {
        return view('admin.queries.show')->with([
            'query' =>  $query
        ]);
    }

    public function destroy(Query $query)
    {
        $query->delete();
        return redirect()->route('admin.queries.index')->withSuccess('SUCCESS !! Query has been deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array'
        ]);

        Query::whereIn('id', $request->input('item_ids'))->delete();
        return redirect()->route('admin.queries.index')->withSuccess('SUCCESS !! Queries has been deleted.');
    }

    public function block(Request $request)
    {
        $request->validate([
            'term' => 'required'
        ]);

        if (!Storage::disk('public')->exists('blocked-queries-terms.txt')) {
            Storage::disk('public')->put('blocked-queries-terms.txt', '');
        }

        $terms = Storage::disk('public')->get('blocked-queries-terms.txt');
        $terms = explode(",", $terms);
        $terms[] = $request->input('term');
        $terms = array_unique($terms);

        Storage::disk('public')->put('blocked-queries-terms.txt', implode(",", $terms));

        return back()->withSuccess('SUCCESS !! Query has been blocked.');
    }

    public function blocked()
    {
        if (!Storage::disk('public')->exists('blocked-queries-terms.txt')) {
            Storage::disk('public')->put('blocked-queries-terms.txt', '');
        }

        $terms = Storage::disk('public')->get('blocked-queries-terms.txt');
        $terms = explode(",", $terms);
        $terms = array_unique($terms);

        return view('admin.queries.blocked')->with([
            'terms' => $terms
        ]);
    }

    public function blockedUpdate(Request $request) {
        $request->validate([
            'terms' => 'required'
        ]);

        $newTerms = explode(",", $request->input('terms'));
        if (!Storage::disk('public')->exists('blocked-queries-terms.txt')) {
            Storage::disk('public')->put('blocked-queries-terms.txt', '');
        }

        $terms = Storage::disk('public')->get('blocked-queries-terms.txt');
        $terms = explode(",", $terms);
        $terms = array_merge($terms, $newTerms);
        $terms = array_unique($terms);

        Storage::disk('public')->put('blocked-queries-terms.txt', implode(",", $terms));

        return back()->withSuccess('SUCCESS !! Query has been blocked.');
    }
}
