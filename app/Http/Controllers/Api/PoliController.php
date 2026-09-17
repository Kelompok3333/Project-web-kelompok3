<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Poli;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::where('is_active', true)->withCount('doctors')->get();
        return response()->json($polis);
    }
}
