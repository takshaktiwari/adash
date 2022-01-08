<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Admin\Blog\BlogCommentController;
use App\Http\Controllers\Admin\Blog\BlogPostController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'gates'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('password', [AdminController::class, 'password'])->name('password');
    Route::post('password', [AdminController::class, 'passwordUpdate'])->name('password.update');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('pages', PageController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('testimonials', TestimonialController::class);

    Route::prefix('blog')->name('blog.')->group(function(){
        Route::resource('categories', BlogCategoryController::class);
        Route::prefix('categories')->name('categories.')->group(function(){
            Route::get('status-toggle/{category}', [BlogCategoryController::class, 'statusToggle'])->name('status-toggle');
            Route::get('featured-toggle/{category}', [BlogCategoryController::class, 'featuredToggle'])->name('featured-toggle');
        });

        Route::resource('posts', BlogPostController::class);
        Route::prefix('posts')->name('posts.')->group(function(){
            Route::get('status-toggle/{post}', [BlogPostController::class, 'statusToggle'])->name('status-toggle');
            Route::get('featured-toggle/{post}', [BlogPostController::class, 'featuredToggle'])->name('featured-toggle');
        });

        Route::resource('comments', BlogCommentController::class)->except(['create', 'store']);
    });
    

    Route::get('login-to/{user:id}', [UserController::class, 'loginToUser'])->name('login-to');
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::prefix('permissions')->name('permissions.')->group(function(){
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::post('{role}', [PermissionController::class, 'update'])->name('update');
    });

    #Adash::Admin-routes ends here (Do not remove this line)
});
