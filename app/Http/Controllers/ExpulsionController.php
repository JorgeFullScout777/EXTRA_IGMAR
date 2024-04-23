<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expulsion;

class ExpulsionController extends Controller
{
    public function index()
    {
        $expulsions = Expulsion::where('is_active', true)->get();
        return response()->json(['data' => $expulsions]);
    }
}
