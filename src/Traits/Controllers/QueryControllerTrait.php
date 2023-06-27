<?php
namespace Takshak\Adash\Traits\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Takshak\Adash\Mail\QueryStoreMail;
use Takshak\Adash\Models\Query;

trait QueryControllerTrait
{
    public function store(Request $request)
    {
        $request->validate([
            'name'  =>  'nullable|string',
            'email'  =>  'nullable|email',
            'mobile'  =>  'nullable|string',
            'subject'  =>  'nullable|string',
            'title'  =>  'nullable|string',
            'content'  =>  'nullable|string',
            'others'  =>  'nullable|array',
        ]);

        $query = Query::create([
            'name'  =>  $request->post('name'),
            'email'  =>  $request->post('email'),
            'mobile'  =>  $request->post('mobile'),
            'subject'  =>  $request->post('subject'),
            'origin'  =>  url()->previous(),
            'title'  =>  $request->post('title'),
            'content'  =>  $request->post('content'),
            'others'  =>  $request->post('others'),
        ]);

        Mail::to(config('site.primary_mail'))->send(new QueryStoreMail($query));

        $route = $request->input('redirect') ? $request->input('redirect') : url()->previous();
        return redirect($route)->withSuccess('Your query has been stored. We will be back in a while. Thank you for choosing us.');
    }
}