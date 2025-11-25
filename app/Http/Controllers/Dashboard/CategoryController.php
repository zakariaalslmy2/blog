<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\categories\StoreCategoryRequest;
use App\Http\Requests\categories\UpdateCategoryRequest;

class CategoryController extends Controller
{

    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        return view('dashboard.categories.index');
    }
        public function getCategoriesDatatable()
    {
        return $this->service->getDatatable();
    }

        public function create()
    {
        $this->authorize('create', Category::class);

        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();

        return view('dashboard.categories.add', compact('categories'));
    }

        public function show(Category $category)
    {
        $this->authorize('view', $category);

    }




    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $this->service->store($request);

        return redirect()->route('dashboard.category.index');
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $this->service->update($request, $category);

        return redirect()->route('dashboard.category.index');
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $this->authorize('delete', $category);

        $this->service->delete($category);

        return redirect()->route('dashboard.category.index');
    }
}
