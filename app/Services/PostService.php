<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use App\Http\Traits\UploadImage;
use Yajra\DataTables\Facades\DataTables;


class PostService
{
    use UploadImage;

    /**
     * إرجاع البيانات إلى الداتا تابل
     */
    public function getDatatable()
    {
        $data = Post::with('category');

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                if (auth()->user()->can('update', $row)) {
                    return '
                        <a href="' . route('dashboard.posts.edit', $row->id) . '"
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

            ->addColumn('category_name', function ($row) {
                return $row->category->translate(app()->getLocale())->title;
            })

            ->addColumn('title', function ($row) {
                return $row->translate(app()->getLocale())->title;
            })

            ->rawColumns(['action', 'title', 'category_name'])
            ->make(true);
    }


    /**
     * إنشاء منشور جديد
     */
    public function store($validated)
    {
        if (isset($validated['image'])) {
            $validated['image'] = $this->uploadImage($validated['image'], 'posts');
        }

        $validated['user_id'] = auth()->id();

        return Post::create($validated);
    }


    /**
     * تحديث منشور
     */
    public function update(Post $post, $request)
    {
        $data = $request->except('image');

        // تحديث الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->image, 'posts');
         }

        $data['user_id'] = auth()->id();

        return $post->update($data);
    }


    /**
     * حذف بوست
     */
    public function delete($id)
    {
        return Post::where('id', $id)->delete();
    }
}