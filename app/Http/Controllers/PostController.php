<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_active', true)->get();
        return response()->json(['data' => $posts]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'content' => 'required|max:200',
            'user_id' => 'required',
            'channel_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $post = Post::create($request->all());
        return response()->json(['data' => $post]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'content' => 'required|max:200',
            'user_id' => 'required',
            'channel_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'post not found'], 404);
        }
        $post->update($request->all());
        return response()->json(['data' => $post]);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'post not found'], 404);
        }
        $post->is_active = false;
        $post->save();
        return response()->json(['data' => 'post deleted']);
    }

    public function posts($ChannelId){
        $posts = Post::where('channel_id', $ChannelId)->where('is_active', true)->get();
        return response()->json(['data' => $posts]);
    }
}