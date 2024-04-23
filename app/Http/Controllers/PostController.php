<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // trae todos los posts activos
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


    // Trae todos los post de un canal
    public function posts($ChannelId){
        $posts = Post::where('channel_id', $ChannelId)->where('is_active', true)->get();
        return response()->json(['data' => $posts]);
    }

    // Trae todos los post de un usuario
    public function postsUser($UserId){
        $posts = Post::where('user_id', $UserId)->get();
        return response()->json(['data' => $posts]);
    }

    //Trae la informacion de un post
    public function show($id){
        $post = Post::find($id);
        $comentarios = Comment::where('post_id', $id)->where('is_active', true)->get();
        if (!$post) {
            return response()->json(['error' => 'post not found'], 404);
        }
        return response()->json(['data' => $post,'comments'=>$comentarios]);
    }
}
