<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }
        return response()->json(['data' => $user]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:40',
            'email' => 'required|email|unique:users',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $user = User::create($request->all());
        return response()->json(['data' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:40',
            'email' => 'required|email|unique:users,email,' . $id,
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }
        $user->update($request->all());
        return response()->json(['data' => $user]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }
        $user->is_active = false;
        $user->save();
        return response()->json(['data' => 'user deleted']);
    }
}
