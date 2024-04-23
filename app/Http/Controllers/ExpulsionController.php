<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expulsion;

class ExpulsionController extends Controller
{
    // Listar usuarios expulsados de un canal
    public function index($id)
    {
        $users = Expulsion::join('users', 'users.id', '=', 'expulsions.user_id')
            ->join('channels', 'channels.id', '=', 'expulsions.channel_id')
            ->where('expulsions.channel_id', $id)
            ->select('users.name as user_name', 'users.id as user_id', 'channels.id as channel_id')
            ->get();
        return response()->json(['data' => $users]);
    }

    // Expulsar usuario de un canal
    public function store(Request $request)
    {
        $expulsion = Expulsion::create($request->all());
        return response()->json(['data' => $expulsion]);
    }

    // Eliminar expulsión de un usuario de un canal
    public function delete($id)
    {
        $expulsion = Expulsion::find($id);
        if (!$expulsion) {
            return response()->json(['error' => 'expulsion not found'], 404);
        }
        $expulsion->delete();
        return response()->json(['data' => 'expulsion deleted']);
    }
}
