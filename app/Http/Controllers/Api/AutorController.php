<?php

namespace App\Http\Controllers\Api;

use App\Models\Autor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $autores = Autor::all();

        return response()->json($autores, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'nacionalidad'     => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $autor = Autor::create($request->all());

        return response()->json([
            'message' => 'Autor registrado correctamente',
            'data'    => $autor,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $autor = Autor::find($id);

        if (!$autor) {
            return response()->json([
                'message' => 'Autor no encontrado'
            ], 404);
        }

        return response()->json($autor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $autor = Autor::find($id);

        if (!$autor) {
            return response()->json([
                'message' => 'Autor no encontrado'
            ], 404);
        }

        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'nacionalidad'     => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $autor->update($request->all());

        return response()->json([
            'message' => 'Autor actualizado correctamente',
            'data'    => $autor,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autor = Autor::find($id);

        if (!$autor) {
            return response()->json([
                'message' => 'Autor no encontrado'
            ], 404);
        }

        $autor->delete();

        return response()->json([
            'message' => 'Autor eliminado correctamente'
        ], 200);
    }
}