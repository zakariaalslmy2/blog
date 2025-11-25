<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Traits\UploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;

class PostsController extends Controller
{
    protected $service;
     use UploadImage;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('dashboard.posts.index');
    }

    public function getPostsDatatable()
    {
        return $this->service->getDatatable();
    }

    public function create()
    {
        $categories = Category::all();
        abort_if($categories->count() == 0, 404);

        return view('dashboard.posts.add', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('dashboard.posts.index')
            ->with('success', __('messages.post_created_successfully'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $this->service->update($post, $request);

        return redirect()->route('dashboard.posts.edit', $post);
    }

    public function delete(Request $request)
    {
        $post = Post::findOrFail($request->id);
        $this->authorize('delete', $post);

        $this->service->delete($request->id);

        return redirect()->route('dashboard.posts.index');
    }
}
