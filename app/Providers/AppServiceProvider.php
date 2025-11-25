<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Category;
use App\Models\settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


    if ($this->app->runningInConsole()) {
        return; // لا تشغل أي استعلام أثناء أوامر artisan
    }

    Paginator::useBootstrap();

    $setting = settings::chackSetting();
    $categories = Category::with('children')
        ->where('parent', 0)
        ->orWhereNull('parent')
        ->get();

    $lastFivePosts = Post::with('category','user')
        ->orderBy('id', 'desc')  // لازم desc
        ->limit(5)
        ->get();

    View()->share([
        'setting' => $setting,
        'categories' => $categories,
        'lastFivePosts' => $lastFivePosts,
    ]);






                DB::listen(function ($query) {
            // هنا يتم استدعاء هذه الدالة لكل استعلام
            // يمكنك عمل dump، log، أو أي شيء آخر
            // dump($query->sql, $query->bindings, $query->time); // مثال على dump

            // مثال على التسجيل في ملف السجل
            Log::info(
                'SQL Query: ' . $query->sql,
                [
                    'bindings' => $query->bindings,
                    'time_ms' => $query->time,
                    'connection' => $query->connectionName
                ]
            );



            DB::listen(function ($query) {
    Log::debug( // يمكن استخدام debug, info, warning
        'SQL: ' . $query->sql . ' | Bindings: ' . implode(', ', $query->bindings) . ' | Time: ' . $query->time . 'ms'
    );
});
        });




    }

}
