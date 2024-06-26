<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ChannelController extends Controller
{
    // trae todos los canales activos
    public function index()
    {
        $channels = Channel::where('is_active', true)->get();
        return Inertia::render('Dashboard', ['channels' => $channels]);
    }

    public function index_json()
    {
        $channels = Channel::where('is_active', true)->get();
        return response()->json(['channels' => $channels]);
    }

    public function index_json_admin()
    {
        $channels = Channel::all();
        return response()->json(['channels' => $channels]);
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
        if($channel->user_id != auth()->user()->id){
            return response()->json(['error' => 'user is not the owner of the channel'], 403);
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
        if($channel->user_id == auth()->user()->id || auth()->user()->role_id == 1){
            $channel->is_active = false;
            $channel->save();
            return response()->json(['data' => 'channel deleted']);
        }
        return response()->json(['error' => 'user is not the owner of the channel'], 403);

    }

    public function enable($id)
    {
        $channel = Channel::find($id);
        if (!$channel) {
            return response()->json(['error' => 'channel not found'], 404);
        }
        $channel->is_active = true;
        $channel->save();
        return response()->json(['data' => 'channel enabled']);
    }

    // Trae todos los canales de un usuario
    public function channelsUser($id)
    {
        if($id != auth()->user()->id){
            return response()->json(['error' => 'user is not the owner of the channel'], 403);
        }
        $channels = Channel::where('user_id', $id)->where('is_active', true)->get();
        return response()->json(['data' => $channels]);
    }

    public function info_channel($id){
        $channel = Channel::find($id);
        if(!$channel){
            return response()->json(['error' => 'channel not found']);
        }
        if($channel->user_id != auth()->user()->id){
            return response()->json(['error' => 'user is not the owner of the channel'], 403);
        }
        return Inertia::render('EditarCanal', ['channel' => $channel]);
    }

    // Trae la informacion de un solo channel
    public function show($id){
        $channel = Channel::find($id);
        if(!$channel){
            return response()->json(['error' => 'channel not found']);
        }
        if($channel->user_id != auth()->user()->id || auth()->user()->role_id != 1){
            return response()->json(['error' => 'user is not the owner of the channel'], 403);

        }
        return response()->json(['data' => $channel]);
    }

}
