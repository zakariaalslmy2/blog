<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheakLangApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\loginController;
use App\Http\Controllers\api\loginContdroller;
use App\Http\Controllers\api\dashboard\SettingController;
use App\Http\Controllers\api\dashboard\CategoriesController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::group(['prefix' => 'v1', 'as' => 'dashboard.', 'middleware' => [ CheakLangApi::class]], function () {


            Route::get('settings', [SettingController::class, 'index'])->name('setting');
            Route::get('category_nav_bar', [CategoriesController::class, 'category_nav_bar'])->name('category_nav_bar');
            Route::get('categories_with_posts', [CategoriesController::class, 'categories_with_posts'])->name('categories_with_posts');

            //login
            Route::post('login', [loginController::class, 'login'])->name('login')->middleware('auth:sanctum');;



});