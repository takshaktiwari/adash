<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use App\DataTables\QueriesDataTable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
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

    public function bulkDelete(Request $request) {
        $request->validate([
            'item_ids' => 'required|array'
        ]);

        Query::whereIn('id', $request->input('item_ids'))->delete();
        return redirect()->route('admin.queries.index')->withSuccess('SUCCESS !! Queries has been deleted.');
    }
}
