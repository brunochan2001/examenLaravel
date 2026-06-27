<?php

namespace App\Http\Controllers\Api;

use App\Models\Autoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $autorias = Autoria::with(['autor', 'libro'])->get();

        return response()->json($autorias, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'autor_id' => 'required|exists:autores,id',
            'libro_id' => 'required|exists:libros,id',
        ]);

        $existe = Autoria::where('autor_id', $request->autor_id)
        ->where('libro_id', $request->libro_id)
        ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Esta autoría ya existe (autor y libro ya están relacionados)'
            ], 409);
        }

        $autoria = Autoria::create($request->all());

        return response()->json([
            'message' => 'Autoría registrada correctamente',
            'data' => $autoria
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $autoria = Autoria::with(['autor', 'libro'])->find($id);

        if (!$autoria) {
            return response()->json([
                'message' => 'Autoría no encontrada'
            ], 404);
        }

        return response()->json($autoria, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $autoria = Autoria::find($id);

        if (!$autoria) {
            return response()->json([
                'message' => 'Autoría no encontrada'
            ], 404);
        }

        $request->validate([
            'autor_id' => 'required|exists:autores,id',
            'libro_id' => 'required|exists:libros,id',
        ]);

        $autoria->update($request->all());

        return response()->json([
            'message' => 'Autoría actualizada correctamente',
            'data' => $autoria
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autoria = Autoria::find($id);

        if (!$autoria) {
            return response()->json([
                'message' => 'Autoría no encontrada'
            ], 404);
        }

        $autoria->delete();

        return response()->json([
            'message' => 'Autoría eliminada correctamente'
        ], 200);
    }
}