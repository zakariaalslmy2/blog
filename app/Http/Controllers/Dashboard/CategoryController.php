<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
// use App\Models\settings; // لم نعد بحاجة لهذا
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.categories.index');
    }


    public function getCategoriesDatatable()
    {
        $data = Category::select('*')->with('parents');
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // يمكنك التحقق هنا باستخدام gate أو policy أيضاً
                // if (auth()->user()->can('update', $row)) { ... }
                // if (auth()->user()->can('delete', $row)) { ... }
                // بما أن كل الصلاحيات للادمن، يمكنك الإبقاء على التحقق الحالي مؤقتاً
                if (auth()->user()->status == 'admin') {
                    return $btn = '
                        <a href="' . Route('dashboard.category.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
                        <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
                }
            })
            // ... باقي دوال datatable
            ->addColumn('parent', function ($row) {
                return ($row->parent ==  0) ? trans('words.main category') :   $row->parents->translate(app()->getLocale())->title;
            })
            ->addColumn('title', function ($row) {
                return $row->translate(app()->getLocale())->title;
            })
            ->addColumn('status', function ($row) {
                return $row->status == null ? __('words.not activated') : __('words.' . $row->status);
            })
            ->rawColumns(['action', 'status', 'title'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // استخدم الموديل الصحيح للتحقق من صلاحية الإنشاء
        $this->authorize('create', Category::class);
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // استخدم الموديل الصحيح للتحقق من صلاحية الإنشاء
        $this->authorize('create', Category::class);
        $category =  Category::create($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;
            $category->update(['image' => $path]);
        }
        return redirect()->route('dashboard.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) // الأفضل استخدام Route Model Binding
    {
        $this->authorize('view', $category);
        // ...
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) // الأفضل استخدام Route Model Binding
    {
        $this->authorize('update', $category);
        // ...
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category) // الأفضل استخدام Route Model Binding
    {
        $this->authorize('update', $category);
        // ...
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $this->authorize('delete', $category);

        if (is_numeric($request->id)) {
            Category::where('parent', $request->id)->delete();
            Category::where('id', $request->id)->delete();
        }

        return redirect()->route('dashboard.category.index');
    }
}
