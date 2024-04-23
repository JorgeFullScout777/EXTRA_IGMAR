<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('is_active', true)->get();
        return response()->json(['data' => $messages]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'content' => 'required|max:200',
            'user_id' => 'required',
            'channel_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $message = Message::create($request->all());
        return response()->json(['data' => $message]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'content' => 'required|max:200',
            'user_id' => 'required',
            'channel_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['error' => 'message not found'], 404);
        }
        $message->update($request->all());
        return response()->json(['data' => $message]);
    }

    public function delete($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['error' => 'message not found'], 404);
        }
        $message->is_active = false;
        $message->save();
        return response()->json(['data' => 'message deleted']);
    }

    public function messages($id)
    {
        $messages = Message::where('channel_id', $id)->where('is_active', true)->get();
        return response()->json(['data' => $messages]);
    }
}
