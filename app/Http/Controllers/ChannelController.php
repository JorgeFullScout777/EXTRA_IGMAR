<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::where('is_active', true)->get();
        return response()->json(['data' => $channels]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:40',
            'description' => 'required|max:200|nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $channel = Channel::create($request->all());
        return response()->json(['data' => $channel]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:40',
            'description' => 'required|max:200|nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $channel = Channel::find($id);
        if (!$channel) {
            return response()->json(['error' => 'channel not found'], 404);
        }
        $channel->update($request->all());
        return response()->json(['data' => $channel]);
    }

    public function delete($id)
    {
        $channel = Channel::find($id);
        if (!$channel) {
            return response()->json(['error' => 'channel not found'], 404);
        }
        $channel->is_active = false;
        $channel->save();
        return response()->json(['data' => 'channel deleted']);
    }

}
