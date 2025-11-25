<?php

namespace App\Services;

use App\Models\Category;
use App\Http\Traits\UploadImage;
use Yajra\DataTables\Facades\DataTables;

class CategoryService
{
    use UploadImage;

    /**
     * Store new category
     */
    public function store($request)
    {
        $category = Category::create($request->except('image'));

        if ($request->hasFile('image')) {
            $category->image = $this->uploadImage($request->file('image'), 'categories');
            $category->save();
        }

        return $category;
    }


    /**
     * Update category
     */
    public function update($request, Category $category)
    {
        $category->update($request->except('image'));

        if ($request->hasFile('image')) {
            $category->image = $this->uploadImage($request->file('image'), 'categories');
            $category->save();
        }

        return $category;
    }


    /**
     * Delete category (with its children)
     */
    public function delete(Category $category)
    {
        // Delete child categories
        Category::where('parent', $category->id)->delete();

        // Delete category
        $category->delete();
    }


    /**
     * DataTables
     */
    public function getDatatable()
    {
        $data = Category::select('*')->with('parents');

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                if (auth()->user()->status == 'admin') {
                    return '
                        <a href="' . route('dashboard.category.edit', $row->id) . '"
                            class="edit btn btn-success btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a id="deleteBtn" data-id="' . $row->id . '"
                            class="edit btn btn-danger btn-sm"
                            data-toggle="modal" data-target="#deletemodal">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                }
                return '';
            })

            ->addColumn('parent', function ($row) {
                return ($row->parent == 0)
                    ? trans('words.main category')
                    : $row->parents->translate(app()->getLocale())->title;
            })

            ->addColumn('title', function ($row) {
                return $row->translate(app()->getLocale())->title;
            })

            ->addColumn('status', function ($row) {
                return $row->status == null
                    ? __('words.not activated')
                    : __('words.' . $row->status);
            })

            ->rawColumns(['action', 'status', 'title'])
            ->make(true);
    }
}
