<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index($value='')
    {
        $blog_posts_count         = \App\Models\Blog\BlogPost::count();
        $blog_categories_count    = \App\Models\Blog\BlogCategory::count();
        $blog_comments_count      = \App\Models\Blog\BlogComment::count();
        $faqs_count   = \App\Models\Faq::count();
        $pages_count  = \App\Models\Page::count();
        $users_count  = \App\Models\User::count();

        return view('admin.dashboard', compact(
            'blog_posts_count',
            'blog_categories_count',
            'blog_comments_count',
            'faqs_count',
            'pages_count',
            'users_count',
        ));
    }

    public function password()
    {
        return view('admin.password');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password'  =>  'required',
            'new_password'  =>  'required|confirmed'
        ]);

        if (\Hash::check($request->input('old_password'), Auth::user()->password)) {
            Auth::user()->update(['password' => \Hash::make($request->input('new_password'))]);
            return redirect()->back()
                            ->withSuccess('UPDATED !! Your password is successfully updated');

        }else{
            return redirect()->back()->withErrors('ERROR !! Old password is not correct');
        }
    }
}
