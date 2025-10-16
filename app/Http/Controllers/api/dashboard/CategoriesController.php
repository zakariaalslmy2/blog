<?php

namespace App\Http\Controllers\api\dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CatgoryResource;
use App\Http\Resources\CatgoryCollection;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function category_nav_bar()
    {

        $categories = Category::with('children')->where('parent' , 0)->orWhere('parent' , null)->get();
        $categories=  CatgoryResource::collection($categories);
        return response()->json( $categories );

    }
        public function categories_with_posts()
    {
      $categories_with_posts = Category::with(relations: 'latestTwoPosts.translations')->get();
    //    $categories_with_posts = Category::with( ['latestTwoPosts','translations'])->get();
      return  new CatgoryCollection($categories_with_posts );

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
