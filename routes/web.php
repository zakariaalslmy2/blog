<?php
use App\Http\Middleware\cheack_login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\settingController;
use App\Http\Controllers\Dashboard\UserController;




Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth', cheack_login::class]
], function () {
    // باقي الروتات...
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('index'); // يمكنك تسمية هذا الروت index إذا أردت


    Route::get('/setting', function () {
        return view('dashboard.setting');
    })->name("dashboard.setting");

    // Route::post('/setting/update', [settingController::class,'update'])->name("setting.update");
    Route::post('/setting/update/{setting}', [settingController::class, 'update'])->name('settings.update');

    Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
    Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');

    Route::get('/users/all2', [UserController::class, 'getUser'])->name('users.all2');
    Route::resources([
    'users' => UserController::class,
    'settings' => settingController::class,

]);
});
Auth::routes();


// Route::group([
//     'prefix' => 'dashboard',
//     'as' => 'dashboard',
//     // استخدم اسم الكلاس الكامل هنا
//     'middleware' => ['auth', cheack_login::class]
// ], function () {
//     Route::get('/', function () {
//         return view('dashboard.index');
//     })->name('index'); // يمكنك تسمية هذا الروت index إذا أردت


//     Route::get('/setting', function () {
//         return view('dashboard.setting');
//     })->name("dashboard.setting");

//     // Route::post('/setting/update', [settingController::class,'update'])->name("setting.update");
//         Route::post('/setting/update/{setting}', [settingController::class, 'update'])->name('settings.update');
//  // تم تعديل الاسم ليتوافق مع 'as' => 'dashboard.'

//  Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
//  Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');

//  Route::resources([
//     'users' => UserController::class,

// ]);

// })->name(value: "dashboard");
// Auth::routes();



// Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
// Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');
// Route::resources([
//     'users' => UserController::class,

// ]);
Route::get('/setting', function () {
    return view('dashboard.setting');
})->name("dashboard.setting");
Route::post('/setting/update/{setting}', [settingController::class, 'update'])->name('settings.update');


    Route::get('/users/all', [UserController::class, 'getUser'])->name('users.all');

    Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');



















// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




// Route::get('/', [IndexController::class, 'index'])->name('index');
// Route::get('/categories/{category}', [WebsiteCategoryController::class, 'show'])->name('category');
// Route::get('/post/{post}', [PostController::class, 'show'])->name('post');












// Dashboard


// Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', cheack_login::class]], function () {

//     Route::get('/', function () {
//         return view('dashboard.layout.layout');
//     })->name('index');


//     // Route::get('/settings', [SettingController::class, 'index'])->name('dashboard.setting');

//     // Route::post('/settings/update/{setting}', [SettingController::class, 'update'])->name('settings.update');


//     Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
//     Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');


//     // Route::get('/category/all', [CategoryController::class, 'getCategoriesDatatable'])->name('category.all');
//     // Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete');



//     // Route::get('/posts/all', [PostsController::class, 'getPostsDatatable'])->name('posts.all');
//     // Route::post('/posts/delete', [PostsController::class, 'delete'])->name('posts.delete');


//     Route::resources([
//         'users' => UserController::class,

//         // 'category' => CategoryController::class,
//         // 'posts' => PostsController::class,
//     ]);
// });
// Route::get('/settings', [SettingController::class, 'index'])->name('dashboard.setting');

// Route::post('/settings/update/{setting}', [SettingController::class, 'update'])->name('settings.update');
// Auth::routes();
