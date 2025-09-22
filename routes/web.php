<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\cheack_login;
// Dashboard


// Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', cheack_login::class]], function () {

//     Route::get('/', function () {
//         return view('dashboard.layout.layout');
//     })->name('index');


//     Route::get('/settings', [SettingController::class, 'index'])->name('dashboard.settings.index');

//     Route::post('/settings/update/{setting}', [SettingController::class, 'update'])->name('settings.update');


//     Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
//     Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');


//     Route::get('/category/all', [CategoryController::class, 'getCategoriesDatatable'])->name('category.all');
//     Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete');



//     Route::get('/posts/all', [PostsController::class, 'getPostsDatatable'])->name('posts.all');
//     Route::post('/posts/delete', [PostsController::class, 'delete'])->name('posts.delete');


//     Route::resources([
//         'users' => UserController::class,
//         'settings' => settingController::class,
//         'category' => CategoryController::class,
//         'posts' => PostsController::class,
//     ]);
// });

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\SettingController; // تأكد من استدعاء الكنترولرز
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostsController;
use App\Http\Middleware\CheackLogin; // تأكد من المسار الصحيح للميدل وير
use App\Http\Controllers\Website\CategoryController as WebsiteCategoryController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\PostController;






// website


Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/categories/{category}', [WebsiteCategoryController::class, 'show'])->name('category');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::group(
    [
        // المجموعة الخارجية: خاصة بتعدد اللغات
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

        // المجموعة الداخلية: خاصة بلوحة التحكم
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', cheack_login::class]], function () {

            // ---> Route: /en/dashboard
            Route::get('/', function () {
                return view('dashboard.layout.layout');
            })->name('index'); // -> dashboard.index

            // ---> Routes for settings
            Route::post('/settings/update/{setting}', [SettingController::class, 'update'])->name('settings.update'); // -> dashboard.settings.update

            // ---> Routes for DataTables
            Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all'); // -> dashboard.users.all
            Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete'); // -> dashboard.users.delete

            Route::get('/category/all', [CategoryController::class, 'getCategoriesDatatable'])->name('category.all'); // -> dashboard.category.all
            Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete'); // -> dashboard.category.delete

            Route::get('/posts/all', [PostsController::class, 'getPostsDatatable'])->name('posts.all'); // -> dashboard.posts.all
            Route::post('/posts/delete', [PostsController::class, 'delete'])->name('posts.delete'); // -> dashboard.posts.delete

            // ---> Resource Routes
            // سيتم تطبيق البادئات والأسماء عليها تلقائيًا
            Route::resources([
                'users' => UserController::class,
                'settings' => SettingController::class,
                'category' => CategoryController::class,
                'posts' => PostsController::class,
            ]);
        });
});
Auth::routes();
