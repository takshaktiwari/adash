<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Takshak\Adash\Models\Query;

trait QueryTrait
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $queries = Query::latest()->paginate(100);
        return view('admin.queries.index')->with([
            'queries' => $queries
        ]);
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
}
