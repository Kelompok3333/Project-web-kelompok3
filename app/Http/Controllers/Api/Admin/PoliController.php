<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoliController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Poli::latest()->get()]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'code'              => 'required|string|unique:polis,code|max:10',
            'description'       => 'nullable|string',
            'max_queue_per_day' => 'required|integer|min:1',
            'is_active'         => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $poli = Poli::create($validator->validated());

        return response()->json(['message' => 'Poli berhasil ditambahkan', 'data' => $poli], 201);
    }

    public function update(Request $request, $id)
    {
        $poli = Poli::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'              => 'sometimes|required|string|max:255',
            'code'              => 'sometimes|required|string|max:10|unique:polis,code,' . $poli->id,
            'description'       => 'nullable|string',
            'max_queue_per_day' => 'sometimes|required|integer|min:1',
            'is_active'         => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $poli->update($validator->validated());

        return response()->json(['message' => 'Data poli diperbarui', 'data' => $poli->fresh()]);
    }

    public function destroy($id)
    {
        $poli = Poli::findOrFail($id);

        // Cek apakah ada dokter aktif di poli ini
        if ($poli->doctors()->where('is_active', true)->exists()) {
            return response()->json([
                'message' => 'Poli tidak dapat dihapus karena masih ada dokter aktif.',
            ], 422);
        }

        $poli->delete();

        return response()->json(['message' => 'Poli berhasil dihapus']);
    }
}
