<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::where('is_active', true)->get();
        return response()->json(['data' => $comments]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'content' => 'required|max:200',
            'user_id' => 'required',
            'post_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $comment = Comment::create($request->all());
        return response()->json(['data' => $comment]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'content' => 'required|max:200',
            'user_id' => 'required',
            'post_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'comment not found'], 404);
        }
        $comment->update($request->all());
        return response()->json(['data' => $comment]);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'comment not found'], 404);
        }
        $comment->is_active = false;
        $comment->save();
        return response()->json(['data' => 'comment deleted']);
    }

    public function comments($id)
    {
        $comments = Comment::where('post_id', $id)->where('is_active', true)->get();
        return response()->json(['data' => $comments]);
    }
}
