<?php

namespace App\Http\Controllers;

use App\Http\Resources\post\PostResource;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $data = Post::all();
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Post::find($id);

        if (is_null($data)) {
            return response()->json('Data not found', 404);
        }
        return new PostResource($data);
        // return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:4',
            'body' => 'required|max:255',
        ]);
        $data = Post::create($validatedData);
        return response()->json($data, 201);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json('success', 204);
    }
}
