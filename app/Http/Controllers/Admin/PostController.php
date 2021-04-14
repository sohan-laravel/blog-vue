<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::with('category', 'user')->get();

        return response()->json(["post" => $post], 200);
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
        Post::create([
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
        $post = Post::where('slug', $slug)->first();

        return response()->json(["post" => $post], 200);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            "name"   => "required",
            "status" => "required"
        ]);

        $title = $request->name;

        $post = Post::find($request->id);

        $post->name     = $request->name;
        $post->slug     = Str::slug($title);
        $post->status   = $request->status;

        if ($post->save()) {
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
        $post = Post::where('slug', $slug)->first();

        if ($post->delete()) {
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
            $post = Post::find($id);
            $post->delete();
            $sl++;
        }

        $success = $sl > 0;
        return response()->json(["success" => $success, 'total' => $sl], 200);
    }

    public function changeStatus(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            $post = Post::find($id);
            $post->status = $request->status;
            $post->save();
            $sl++;
        }

        $success = $sl > 0;
        return response()->json(["success" => $success, 'total' => $sl], 200);
    }
}
