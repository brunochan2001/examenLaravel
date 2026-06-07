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

        return response()->json([
            'success' => true,
            'data'    => $autores,
        ], 200);
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
            'success' => true,
            'data'    => $autor,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
