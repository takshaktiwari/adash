<?php

namespace Takshak\Adash\Traits\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
            'files'  =>  'nullable|array',
            'files.*'  =>  'nullable|file',
        ]);

        if (Storage::disk('public')->exists('blocked-queries-terms.txt')) {
            $blockedTerms = explode(',', Storage::disk('public')->get('blocked-queries-terms.txt'));

            foreach ($blockedTerms as $block) {
                if (str($request->post('name'))->contains($block)) {
                    return back();
                }
                if (str($request->post('email'))->contains($block)) {
                    return back();
                }
                if (str($request->post('mobile'))->contains($block)) {
                    return back();
                }
                if (str($request->ip())->contains($block)) {
                    return back();
                }
            }
        }

        $others = $request->post('others') ?? [];
        if ($request->file('files')) {
            foreach ($request->file('files') as $key => $file) {
                $filePath = $file->storeAs(
                    'queries',
                    str()->of(microtime())->slug('-')->append('.' . $file->extension()),
                    'public'
                );
                $others[$key] = storage($filePath);
            }
        }

        $query = Query::create([
            'name'  =>  $request->post('name'),
            'email'  =>  $request->post('email'),
            'mobile'  =>  $request->post('mobile'),
            'subject'  =>  $request->post('subject'),
            'origin'  =>  url()->previous(),
            'title'  =>  $request->post('title'),
            'content'  =>  $request->post('content'),
            'others'  =>  $others,
            'ip'  =>  $request->ip(),
        ]);

        try {
            Mail::to(setting('primary_email', 'hello@example.com'))->send(new QueryStoreMail($query));
        } catch (\Throwable $th) {
            logger($th);
        }


        $route = $request->input('redirect')
            ? $request->input('redirect')
            : url()->previous();

        return redirect($route)->withSuccess('Your query has been stored. We will be back in a while. Thank you for choosing us.');
    }
}
