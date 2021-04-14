<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "categories" => $categories
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"   => "required",
            "status" => "required"
        ]);
        $title = $request->name;
        Category::create([
            "name"   => $request->name,
            "slug"   => Str::slug($title),
            "status"   => $request->status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        return response()->json(["category" => $category], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            "name"   => "required",
            "status" => "required"
        ]);

        $title = $request->name;

        $category = Category::find($request->id);

        $category->name     = $request->name;
        $category->slug     = Str::slug($title);
        $category->status   = $request->status;

        if ($category->save()) {
            $success = true;
        } else {
            $success = false;
        }
        return response()->json(["success" => $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if ($category->delete()) {
            $success = true;
        } else {
            $success = false;
        }
        return response()->json(["success" => $success], 200);
    }

    public function removeItems(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            $category = Category::find($id);
            $category->delete();
            $sl++;
        }

        $success = $sl > 0;
        return response()->json(["success" => $success, 'total' => $sl], 200);
    }

    public function changeStatus(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            $category = Category::find($id);
            $category->status = $request->status;
            $category->save();
            $sl++;
        }

        $success = $sl > 0;
        return response()->json(["success" => $success, 'total' => $sl], 200);
    }
}
