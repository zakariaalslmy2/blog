<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post; // !! لا تنس إضافة هذا السطر لاستخدام موديل Post
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        // 1. جلب الأقسام مع آخر مقالين لكل قسم
        $categories_with_posts = Category::with('latestTwoPosts')->get();

        // 2. جلب آخر 5 مقالات للسلايدر العلوي
        $lastFivePosts = Post::latest()->take(5)->get();

        // 3. جلب كل الأقسام لعرضها في الشريط الجانبي
        $categories = Category::all();

        // 4. إرسال جميع المتغيرات المطلوبة إلى الـ view
        return view('website.index', compact(
            'categories_with_posts',
            'lastFivePosts',
            'categories'
        ));
    }
}